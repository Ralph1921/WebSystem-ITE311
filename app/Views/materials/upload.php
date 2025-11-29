<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <?php echo view('templates/header'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="bi bi-file-earmark-arrow-up"></i> Upload Course Material</h3>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label for="course_name" class="form-label"><strong>Course:</strong></label>
                                <input type="text" class="form-control" id="course_name" value="<?= esc($course['title'] ?? 'Course ID: ' . $course_id) ?>" disabled>
                                <small class="text-muted">Course ID: <?= $course_id ?></small>
                            </div>

                            <div class="mb-4">
                                <label for="material_file" class="form-label"><strong>Select File to Upload</strong></label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="material_file" name="material_file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt">
                                    <label class="input-group-text" for="material_file"><i class="bi bi-cloud-arrow-up"></i></label>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle"></i> Allowed formats: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT<br>
                                    <i class="bi bi-info-circle"></i> Maximum file size: 50 MB
                                </small>
                                <div class="invalid-feedback">
                                    Please select a valid file.
                                </div>
                            </div>

                            <div class="mb-4" id="file-preview">
                                <small class="text-muted">No file selected</small>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cloud-arrow-up"></i> Upload Material
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-info-circle"></i> Upload Guidelines</h5>
                        <ul class="mb-0">
                            <li>Upload only educational materials relevant to the course</li>
                            <li>Ensure file names are descriptive and clear</li>
                            <li>Maximum file size is 50 MB</li>
                            <li>Supported formats: PDF, Word documents, PowerPoint presentations, Excel spreadsheets, and text files</li>
                            <li>Uploaded materials will be accessible to all enrolled students</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File preview
        document.getElementById('material_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('file-preview');
            
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                preview.innerHTML = `
                    <div class="alert alert-info">
                        <strong><i class="bi bi-file-earmark"></i> File Selected:</strong><br>
                        Name: ${file.name}<br>
                        Size: ${fileSize} MB<br>
                        Type: ${file.type}
                    </div>
                `;
            } else {
                preview.innerHTML = '<small class="text-muted">No file selected</small>';
            }
        });

        // Form validation
        (() => {
            'use strict';
            window.addEventListener('load', () => {
                const forms = document.querySelectorAll('.needs-validation');
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            });
        })();
    </script>
</body>
</html>
