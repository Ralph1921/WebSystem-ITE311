(() => {
  'use strict';
  const ENROLL_URL = '/course/enroll';
  const BUTTON_SELECTOR = '.btn-enroll';
  const TOAST_ID = 'enroll-toast';

  function getCsrf() {
    const nameTag = document.querySelector('meta[name="csrf-name"]');
    const hashTag = document.querySelector('meta[name="csrf-hash"]');
    if (nameTag && hashTag) {
      return { name: nameTag.content, value: hashTag.content };
    }
    return null;
  }

  function showToast(message, type = 'info', timeout = 3500) {
    const el = document.getElementById(TOAST_ID);
    if (!el) return;
    el.textContent = message;
    el.className = `toast toast-${type}`;
    el.style.display = 'block';
    clearTimeout(el._hideTimer);
    el._hideTimer = setTimeout(() => { el.style.display = 'none'; }, timeout);
  }

  function markEnrolled(button, course, responseData) {
    button.disabled = true;
    button.classList.add('enrolled');
    button.textContent = 'Enrolled';
    const card = button.closest('.course-card');
    if (card) {
      const status = card.querySelector('.enroll-status');
      if (status) {
        const title = (course && course.title) ? course.title : '';
        const when = (responseData && responseData.enrollment && responseData.enrollment.enrollment_date)
                      ? responseData.enrollment.enrollment_date : '';
        status.textContent = `You’re enrolled${when ? ' on ' + when : ''}${title ? ' — ' + title : ''}.`;
        status.style.color = '#2a9d8f';
      }
    }
    showToast('Enrolled successfully!', 'success');
  }

  function handleError(button, message) {
    if (button) button.disabled = false;
    showToast(message || 'Enrollment failed. Try again.', 'error', 5000);
  }

  async function enroll(courseId, button) {
    if (!button || button.disabled) return;
    button.disabled = true;
    const originalText = button.textContent;
    button.textContent = 'Enrolling...';

    const csrf = getCsrf();
    const body = new URLSearchParams();
    body.append('course_id', courseId);
    if (csrf) body.append(csrf.name, csrf.value);

    try {
      const resp = await fetch(ENROLL_URL, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: body.toString()
      });

      const json = await resp.json().catch(() => null);

      if (resp.ok && json && json.success) {
        markEnrolled(button, json.course || null, json);
      } else {
        if (resp.status === 401) {
          handleError(button, 'Please log in to enroll.');
          // optional: redirect to login
          // window.location.href = '/login';
        } else if (resp.status === 409) {
          handleError(button, 'You are already enrolled.');
          button.textContent = 'Enrolled';
          button.disabled = true;
        } else if (json && json.message) {
          handleError(button, json.message);
        } else {
          handleError(button, 'Unexpected server response.');
        }
      }
    } catch (err) {
      console.error('Enroll error', err);
      handleError(button, 'Network error. Check your connection.');
    } finally {
      if (!button.disabled) {
        button.textContent = originalText;
      }
    }
  }

  function init() {
    document.addEventListener('click', (ev) => {
      const btn = ev.target.closest(BUTTON_SELECTOR);
      if (!btn) return;
      ev.preventDefault();
      const courseId = btn.dataset.courseId || btn.getAttribute('data-course-id');
      if (!courseId || !/^\d+$/.test(courseId)) {
        showToast('Invalid course ID', 'error');
        return;
      }
      enroll(courseId, btn);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
