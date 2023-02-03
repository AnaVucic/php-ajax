$(document).ready(function () {
  console.log("Page is ready!");
  const now = new Date();
});

$("#addForm").submit(function () {
  console.log("nesto");
  event.preventDefault();
  const $form = $(this);

  // const $fromspan = $form.find("span");
  // console.log($fromspan);
  // var value = $("#myDate").datepicker("getDate");
  // console.log(value);

  const $input = $form.find("input, select");
  // $input.add(value);
  // console.log($input);
  const serializedData = $form.serialize();
  console.log(serializedData);

  $input.prop('disabled', true);

  request = $.ajax({
    url: 'handler/add.php',
    type: 'post',
    data: serializedData
  });

  request.done(function (response) {
    console.log(response);
    if (response == "Success") {
      console.log("Added new membership");
      location.reload(true);
    } else {
      console.log("Membership not added " + response);
    }
    console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("Error occurred: " + textStatus, errorThrown);
  });
});


$(".edit-membership").click(function () {

  var compositeKey = $(this).val();
  console.log("Filling edit form");
  console.log(compositeKey);
  const keys = compositeKey.split(' ');

  request = $.ajax({
    url: 'handler/get.php',
    type: 'post',
    data: {
      'key1': keys[0],
      'key2': keys[1]
    },
    dataType: 'json',
    error: function (response) {
      console.log(response);
    }
  });

  request.done(function (response) {
    console.log('Form filled');
    console.log(response);

    $('#memberNameEdit').val(response.member.firstname + " " + response.member.lastname);
    $('#memberIDEdit').val(response.member.memberid);
    $('#membershipNameEdit').val(response.membership.membershipname);
    $('#membershipIDEdit').val(response.membership.membershipid);

    var date = new Date(response.startDate.date);
    console.log(date);
    document.getElementById('editDate').value = date.toLocaleDateString("en-US", { year: "numeric", month: "2-digit", day: "2-digit" });

  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
    console.error('The following error occurred: ' + textStatus, errorThrown);
  });

});

$('#editForm').submit(function () {
  event.preventDefault();
  console.log("Editing");
  const $form = $(this);
  const $inputs = $form.find('input');
  const serializedData = $form.serialize();
  console.log(serializedData);
  $inputs.prop('disabled', true);

  request = $.ajax({
    url: 'handler/edit.php',
    type: 'post',
    data: serializedData
  });

  request.done(function (response) {
    if (response === 'Success') {
      console.log('Appointment edited');
      location.reload(true);
    } else console.log('Appointment not edited ' + response);
    console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
    console.error('The following error occurred: ' + textStatus, errorThrown);
  });
});

$(".cancel-membership").click(function () {
  var compositeKey = $(this).val();
  const keys = compositeKey.split(' ');
  console.log("Deleting membership - Member: " + keys[0] + " Membership:" + keys[1]);

  request = $.ajax({
    url: 'handler/delete.php',
    type: 'post',
    data: {
      'deleteKey1': keys[0],
      'deleteKey2': keys[1]
    }
  });

  request.done(function (response) {
    if (response == "Success") {
      console.log('Deleted');
      location.reload();
    } else {
      console.log("Appointment not deleted " + response);
    }
    console.log(response);
  });
});
