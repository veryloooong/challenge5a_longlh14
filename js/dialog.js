$("document").ready(function () {
  // INFO: add student functions
  const addDialog = document.querySelector("#dialog-add-student");
  addDialog.addEventListener("click", (e) => {
    const dialogDimensions = addDialog.getBoundingClientRect();
    if (
      e.clientX < dialogDimensions.left ||
      e.clientX > dialogDimensions.right ||
      e.clientY < dialogDimensions.top ||
      e.clientY > dialogDimensions.bottom
    ) {
      addDialog.close();
    }
  });

  $(".js-add-student-popup").click(function () {
    addDialog.showModal();
  });
  $(".js-add-student-close").click(function () {
    addDialog.close();
  });
  $(".js-add-student").click(function () {
    const password = $("#password").val();
    const passwordConfirm = $("#password_confirm").val();
    const passwordAlert = $(".password-alert");

    if (password !== passwordConfirm) {
      passwordAlert.html("Mật khẩu xác nhận không khớp");
      passwordAlert.show();
    } else if (
      password.length < 8 ||
      !/[A-Z]/.test(password) ||
      !/[a-z]/.test(password) ||
      !/[0-9]/.test(password) ||
      !/[!@#$%^&*()\-_+=]/.test(password)
    ) {
      passwordAlert.html("Mật khẩu mới chưa đáp ứng bảo mật");
      passwordAlert.show();
    } else {
      passwordAlert.hide();
      $("#form-add-student").trigger("submit");
    }
  });

  // INFO: edit student

  // INFO: delete student
  const deleteDialog = document.querySelector("#dialog-delete-student");
  deleteDialog.addEventListener("click", (e) => {
    const dialogDimensions = addDialog.getBoundingClientRect();
    if (
      e.clientX < dialogDimensions.left ||
      e.clientX > dialogDimensions.right ||
      e.clientY < dialogDimensions.top ||
      e.clientY > dialogDimensions.bottom
    ) {
      addDialog.close();
    }
  });

  $(".js-delete-student-popup").click(function () {
    deleteDialog.showModal();
  });
  $(".js-delete-student-close").click(function () {
    deleteDialog.close();
  });
});
