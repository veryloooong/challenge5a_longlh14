$("document").ready(function () {
  const infoChangeButton = $(".js-change-info");
  const infoChangeForm = $(".form-change-info");
  const infoConfirmButton = $(".js-change-info-confirm");

  const passChangeButton = $(".js-change-pass");
  const passChangeForm = $(".form-change-pass");
  const passConfirmButton = $(".js-change-pass-confirm");

  const personalInfo = $(".personal-info");

  infoChangeButton.click(function () {
    if (infoChangeForm.is(":hidden")) {
      infoChangeForm.show();
      infoChangeButton.addClass("bg-red-500").removeClass("bg-blue-500");
      infoChangeButton.html("Hủy thay đổi");
      passChangeButton.hide();
      infoConfirmButton.show();
      personalInfo.hide();
    } else {
      infoChangeForm.hide();
      infoChangeButton.addClass("bg-blue-500").removeClass("bg-red-500");
      infoChangeButton.html("Chỉnh sửa thông tin");
      passChangeButton.show();
      infoConfirmButton.hide();
      personalInfo.show();
    }
  });

  passChangeButton.click(function () {
    if (passChangeForm.is(":hidden")) {
      passChangeForm.show();
      passChangeButton.addClass("bg-red-500").removeClass("bg-blue-500");
      passChangeButton.html("Hủy thay đổi");
      infoChangeButton.hide();
      passConfirmButton.show();
      personalInfo.hide();
    } else {
      passChangeForm.hide();
      passChangeButton.addClass("bg-blue-500").removeClass("bg-red-500");
      passChangeButton.html("Đổi mật khẩu");
      infoChangeButton.show();
      passConfirmButton.hide();
      personalInfo.show();
    }
  });

  passConfirmButton.click(function () {
    const passwordOld = $(".pass-change-old");
    const passwordNew = $(".pass-change-new");
    const passwordConfirm = $(".pass-change-confirm");

    // TODO
  });
});
