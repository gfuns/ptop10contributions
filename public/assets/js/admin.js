$(document).ready(function () {
    $("#status").select2();
});

$(document).ready(function () {
    $("#manufacturer").select2();
});

$(document).ready(function () {
    $("#generic").select2();
});

$(document).ready(function () {
    $("#prods").select2();
});

$("#customa").select2({
    dropdownParent: $("#cartCheckout"),
});

$("#fschedule").select2({
    dropdownParent: $("#offcanvasRight"),
});

$("#paymethod").select2({
    dropdownParent: $("#offcanvasRight"),
});

$("#userrole").select2({
    dropdownParent: $("#offcanvasRight"),
});

$("#customer").select2({
    dropdownParent: $("#offcanvasRight"),
});

$("#produkt").select2({
    dropdownParent: $("#newInvoiceItem"),
});

$("#product").select2({
    dropdownParent: $("#offcanvasRight"),
});

$("#format").select2({
    dropdownParent: $("#offcanvasRight"),
});

$("#fundType").select2({
    dropdownParent: $("#fundAccount"),
});

$("#receiver").select2({
    dropdownParent: $("#transferFunds"),
});

$("#stockTable").DataTable({
    search: true, // disable pagination
    paging: true, // disable pagination
    info: false,
    ordering: false,
});

$("#itemTable").DataTable({
    search: true, // disable pagination
    paging: false, // disable pagination
    info: false,
    ordering: false,
});

$("#salesTable").DataTable({
    paging: true, // disable pagination
    searching: false, // disable pagination
    info: false,
    ordering: false,
    lengthChange: false,
});

function validateInput(event) {
    const input = event.target;
    let value = input.value;

    // Remove commas from the input value
    value = value.replace(/,/g, "");

    // Regular expression to match non-numeric and non-decimal characters
    const nonNumericDecimalRegex = /[^0-9.]/g;

    if (nonNumericDecimalRegex.test(value)) {
        // If non-numeric or non-decimal characters are found, remove them from the input value
        value = value.replace(nonNumericDecimalRegex, "");
    }

    // Ensure there is only one decimal point in the value
    const decimalCount = value.split(".").length - 1;
    if (decimalCount > 1) {
        value = value.replace(/\./g, "");
    }

    // Assign the cleaned value back to the input field
    input.value = value;
}

function valInvNo(event) {
    const input = event.target;
    let value = input.value;

    // Allow only letters, numbers, and hyphen
    value = value.replace(/[^a-zA-Z0-9-]/g, "");

    // Optional: prevent leading hyphen
    value = value.replace(/^-+/, "");

    // Optional: prevent multiple consecutive hyphens
    value = value.replace(/--+/g, "-");

    input.value = value;
}

$("#editUserRole").on("show.bs.offcanvas", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var role = button.data("userole"); // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this);
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find(".offcanvas-body #myid").val(myid);
    offcanvas.find(".offcanvas-body #userole").val(role);
});

$("#editStaff").on("show.bs.offcanvas", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var othernames = button.data("othernames"); // Extract info from data-* attributes
    var lastname = button.data("lastname"); // Extract info from data-* attributes
    var email = button.data("email"); // Extract info from data-* attributes
    var phone = button.data("phone"); // Extract info from data-* attributes
    var role = button.data("role"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this);
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find(".offcanvas-body #myid").val(myid);
    offcanvas.find(".offcanvas-body #othernames").val(othernames);
    offcanvas.find(".offcanvas-body #lastname").val(lastname);
    offcanvas.find(".offcanvas-body #email").val(email);
    offcanvas.find(".offcanvas-body #phone").val(phone);
    $("#uuserrole")
        .select2({
            dropdownParent: $("#editStaff"),
        })
        .val(role)
        .trigger("change");
});

$("#editMember").on("show.bs.offcanvas", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var othernames = button.data("othernames"); // Extract info from data-* attributes
    var lastname = button.data("lastname"); // Extract info from data-* attributes
    var email = button.data("email"); // Extract info from data-* attributes
    var phone = button.data("phone"); // Extract info from data-* attributes
    var address = button.data("address"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this);
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find(".offcanvas-body #myid").val(myid);
    offcanvas.find(".offcanvas-body #othernames").val(othernames);
    offcanvas.find(".offcanvas-body #lastname").val(lastname);
    offcanvas.find(".offcanvas-body #email").val(email);
    offcanvas.find(".offcanvas-body #phone").val(phone);
    offcanvas.find(".offcanvas-body #address").val(address);
});

$("#viewMember").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var cardno = button.data("cardno"); // Extract info from data-* attributes
    var othernames = button.data("othernames"); // Extract info from data-* attributes
    var lastname = button.data("lastname"); // Extract info from data-* attributes
    var email = button.data("email"); // Extract info from data-* attributes
    var phone = button.data("phone"); // Extract info from data-* attributes
    var address = button.data("address"); // Extract info from data-* attributes
    var regdate = button.data("regdate"); // Extract info from data-* attributes
    var photograph = button.data("photograph"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    document.getElementById("vcardno").innerHTML = cardno;
    document.getElementById("vlastname").innerHTML = lastname;
    document.getElementById("vothernames").innerHTML = othernames;
    document.getElementById("vemail").innerHTML = email;
    document.getElementById("vphone").innerHTML = phone;
    document.getElementById("vaddress").innerHTML = address;
    document.getElementById("vregdate").innerHTML = regdate;
    document.getElementById("vphoto").src = photograph;
});

$("#viewLoanAppDetails").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var cardno = button.data("cardno"); // Extract info from data-* attributes
    var applicant = button.data("applicant"); // Extract info from data-* attributes
    var guarantor = button.data("guarantor"); // Extract info from data-* attributes
    var amount = button.data("amount"); // Extract info from data-* attributes
    var weeklypay = button.data("weeklypay"); // Extract info from data-* attributes
    var status = button.data("status"); // Extract info from data-* attributes
    var photograph = button.data("photograph"); // Extract info from data-* attributes
    var guarantorphoto = button.data("guarantorphoto"); // Extract info from data-* attributes
    var appdate = button.data("appdate"); // Extract info from data-* attributes
    var guarantorcard = button.data("guarantorcard"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    document.getElementById("vcardno").innerHTML = cardno;
    document.getElementById("vapplicant").innerHTML = applicant;
    document.getElementById("vguarantorcard").innerHTML = guarantorcard;
    document.getElementById("vguarantor").innerHTML = guarantor;
    document.getElementById("vamount").innerHTML = amount;
    document.getElementById("vweeklypay").innerHTML = weeklypay;
    document.getElementById("vstatus").innerHTML = status;
    document.getElementById("vappdate").innerHTML = appdate;
    document.getElementById("vphoto").src = photograph;
    document.getElementById("vguarantorphoto").src = guarantorphoto;

    if (document.getElementById("approveLoan")) {
        document.getElementById("approveLoan").href =
            "/portal/admin/new-loan/approve/" + myid;
    }
    if (document.getElementById("rejectLoan")) {
        document.getElementById("rejectLoan").href =
            "/portal/admin/new-loan/reject/" + myid;
    }

    if (status !== "Pending") {
        $("#controlBtns").hide();
    } else {
        $("#controlBtns").show(); // optional, if you want it visible when pending
    }
});

$("#editAmount").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var amount = button.data("amount"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".modal-body #myid").val(myid);
    modal.find(".modal-body #amount").val(amount);

});

$("#viewLoanDetails").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var cardno = button.data("cardno"); // Extract info from data-* attributes
    var applicant = button.data("applicant"); // Extract info from data-* attributes
    var guarantor = button.data("guarantor"); // Extract info from data-* attributes
    var amount = button.data("amount"); // Extract info from data-* attributes
    var weeklypay = button.data("weeklypay"); // Extract info from data-* attributes
    var photograph = button.data("photograph"); // Extract info from data-* attributes
    var guarantorphoto = button.data("guarantorphoto"); // Extract info from data-* attributes
    var appdate = button.data("appdate"); // Extract info from data-* attributes
    var guarantorcard = button.data("guarantorcard"); // Extract info from data-* attributes
    var disbursedate = button.data("disbdate"); // Extract info from data-* attributes
    var totalpaid = button.data("totalpaid"); // Extract info from data-* attributes
    var balance = button.data("balance"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    document.getElementById("vcardno").innerHTML = cardno;
    document.getElementById("vapplicant").innerHTML = applicant;
    document.getElementById("vguarantorcard").innerHTML = guarantorcard;
    document.getElementById("vguarantor").innerHTML = guarantor;
    document.getElementById("vamount").innerHTML = amount;
    document.getElementById("vweeklypay").innerHTML = weeklypay;
    document.getElementById("vappdate").innerHTML = appdate;
    document.getElementById("vphoto").src = photograph;
    document.getElementById("vguarantorphoto").src = guarantorphoto;
    document.getElementById("vdisbdate").innerHTML = disbursedate;
    document.getElementById("vdisbamount").innerHTML = amount;
    document.getElementById("vtotalpaid").innerHTML = totalpaid;
    document.getElementById("vbalance").innerHTML = balance;


});

$("#weeklyPayment").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var cardno = button.data("cardno"); // Extract info from data-* attributes
    var name = button.data("name"); // Extract info from data-* attributes
    var week = button.data("week") + " - " +button.data("date"); // Extract info from data-* attributes
    var schedule = button.data("schedule"); // Extract info from data-* attributes
    var amount = button.data("amount"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".modal-body #myid").val(myid);
    modal.find(".modal-body #cardnum").val(cardno);
    modal.find(".modal-body #name").val(name);
    modal.find(".modal-body #week").val(week);
    modal.find(".modal-body #schedule").val(schedule);
    modal.find(".modal-body #amount").val(amount);

});
