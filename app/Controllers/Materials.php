<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;

class Materials extends BaseController
{
    protected $materialModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
    }

    /**
     * Display upload form and handle file upload
     */
    public function upload($course_id)
    {
        // Check if user is logged in and is instructor/teacher/admin
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('/login'));
        }

        $role = session()->get('role');
        if (!in_array($role, ['admin', 'instructor', 'teacher'])) {
            return redirect()->to(site_url('/dashboard'))->with('error', 'Only instructors can upload materials.');
        }

        // Verify the instructor owns this course
        $db = \Config\Database::connect();
        $course = $db->table('courses')->where('id', $course_id)->where('instructor_id', session()->get('userID'))->get()->getRowArray();

        if (!$course && $role !== 'admin') {
            return redirect()->to(site_url('/dashboard'))->with('error', 'You are not authorized to upload materials for this course.');
        }

        if ($this->request->getMethod() === 'POST') {
            // Load helpers and libraries
            $file = $this->request->getFile('material_file');

            // Validate the file
            $validation = \Config\Services::validation();
            $validation->setRules([
                'material_file' => 'uploaded[material_file]|max_size[material_file,50000]|mime_in[material_file,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/plain]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->with('error', 'Invalid file. Please upload a valid document (PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT). Max size: 50MB')->withInput();
            }

            // Move the file to the uploads directory
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/materials', $newName);

            // Prepare data for database
            $data = [
                'course_id' => $course_id,
                'file_name' => $file->getClientName(),
                'file_path' => 'uploads/materials/' . $newName,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Insert into database
            if ($this->materialModel->insertMaterial($data)) {
                session()->setFlashdata('success', 'Material uploaded successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to save material to database.');
            }

            return redirect()->to(site_url('/dashboard'));
        }

        // Display upload form
        return view('materials/upload', ['course_id' => $course_id, 'course' => $course]);
    }

    /**
     * Delete a material
     */
    public function delete($material_id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('/login'));
        }

        // Get the material
        $material = $this->materialModel->getMaterialById($material_id);

        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Verify authorization
        $db = \Config\Database::connect();
        $course = $db->table('courses')->where('id', $material['course_id'])->get()->getRowArray();
        $user_id = session()->get('userID');
        $role = session()->get('role');

        if ($course['instructor_id'] !== $user_id && $role !== 'admin') {
            return redirect()->back()->with('error', 'You are not authorized to delete this material.');
        }

        // Delete the file from server
        $filepath = WRITEPATH . $material['file_path'];
        if (file_exists($filepath)) {
            unlink($filepath);
        }

        // Delete from database
        if ($this->materialModel->deleteMaterial($material_id)) {
            session()->setFlashdata('success', 'Material deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to delete material.');
        }

        return redirect()->to(site_url('/dashboard'));
    }

    /**
     * Download a material (restricted to enrolled students)
     */
    public function download($material_id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('/login'))->with('error', 'You must be logged in to download materials.');
        }

        // Get the material
        $material = $this->materialModel->getMaterialById($material_id);

        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        $db = \Config\Database::connect();
        $user_id = session()->get('userID');
        $course_id = $material['course_id'];

        // Check if user is enrolled in the course or is instructor/admin
        $role = session()->get('role');
        $is_instructor = $db->table('courses')->where('id', $course_id)->where('instructor_id', $user_id)->countAllResults() > 0;
        $is_enrolled = $db->table('enrollments')->where('user_id', $user_id)->where('course_id', $course_id)->countAllResults() > 0;

        if (!$is_enrolled && !$is_instructor && $role !== 'admin') {
            return redirect()->back()->with('error', 'You are not authorized to download this material.');
        }

        // Prepare the file path
        $filepath = WRITEPATH . $material['file_path'];

        if (!file_exists($filepath)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        // Return the file for download
        return $this->response->download($filepath, null);
    }
}
