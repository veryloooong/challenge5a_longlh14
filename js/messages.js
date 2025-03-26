$("document").ready(function () {
  const deleteDialog = document.querySelector("#dialog-delete-message");
  deleteDialog.addEventListener("click", (e) => {
    const dialogDimensions = deleteDialog.getBoundingClientRect();
    if (
      e.clientX < dialogDimensions.left ||
      e.clientX > dialogDimensions.right ||
      e.clientY < dialogDimensions.top ||
      e.clientY > dialogDimensions.bottom
    ) {
      deleteDialog.close();
    }
  });
  $(".js-delete-message-popup").click(function () {
    const messageId = $(this).val();
    $("#message_id_delete").val(messageId);
    deleteDialog.showModal();
  });
  $(".js-delete-message-close").click(function () {
    deleteDialog.close();
  });

  const editDialog = document.querySelector("#dialog-edit-message");
  editDialog.addEventListener("click", (e) => {
    const dialogDimensions = editDialog.getBoundingClientRect();
    if (
      e.clientX < dialogDimensions.left ||
      e.clientX > dialogDimensions.right ||
      e.clientY < dialogDimensions.top ||
      e.clientY > dialogDimensions.bottom
    ) {
      editDialog.close();
    }
  });
  $(".js-edit-message-popup").click(function () {
    const messageId = $(this).val();
    $("#message_id_edit").val(messageId);
    $("#message_content_edit").val($(`#message-${messageId}`).html().trim());
    editDialog.showModal();
  });
  $(".js-edit-message-close").click(function () {
    editDialog.close();
  });
});
