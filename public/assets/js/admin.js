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

$("#viewAcctTrxDetails").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var staff = button.data("staff"); // Extract info from data-* attributes
    var amount = button.data("amount"); // Extract info from data-* attributes
    var trxtype = button.data("trxtype"); // Extract info from data-* attributes
    var fundingtype = button.data("fundingtype"); // Extract info from data-* attributes
    var bbefore = button.data("bbefore"); // Extract info from data-* attributes
    var bafter = button.data("bafter"); // Extract info from data-* attributes
    var posteddate = button.data("posteddate"); // Extract info from data-* attributes
    var valuedate = button.data("valuedate"); // Extract info from data-* attributes
    var description = button.data("description"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    document.getElementById("vstaff").innerHTML = staff;
    document.getElementById("vamount").innerHTML = amount;
    document.getElementById("vtrxtype").innerHTML = trxtype;
    document.getElementById("vfundingtype").innerHTML = fundingtype;
    document.getElementById("vbbefore").innerHTML = bbefore;
    document.getElementById("vbafter").innerHTML = bafter;
    document.getElementById("vposteddate").innerHTML = posteddate;
    document.getElementById("vvaluedate").innerHTML = valuedate;
    document.getElementById("vdescription").innerHTML = description;
});

$("#viewExpDetails").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var staff = button.data("staff"); // Extract info from data-* attributes
    var amount = button.data("amount"); // Extract info from data-* attributes
    var trxtype = button.data("trxtype"); // Extract info from data-* attributes
    var fundingacct = button.data("fundingacct"); // Extract info from data-* attributes
    var posteddate = button.data("posteddate"); // Extract info from data-* attributes
    var valuedate = button.data("valuedate"); // Extract info from data-* attributes
    var description = button.data("description"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    document.getElementById("vstaff").innerHTML = staff;
    document.getElementById("vamount").innerHTML = amount;
    document.getElementById("vtrxtype").innerHTML = trxtype;
    document.getElementById("vfundingacct").innerHTML = fundingacct;
    document.getElementById("vposteddate").innerHTML = posteddate;
    document.getElementById("vvaluedate").innerHTML = valuedate;
    document.getElementById("vdescription").innerHTML = description;
});

$("#updateInvoiceItem").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var batchno = button.data("batchno"); // Extract info from data-* attributes
    var expiry = button.data("expiry"); // Extract info from data-* attributes
    var totalpacks = button.data("totalpacks"); // Extract info from data-* attributes
    var totalblisters = button.data("totalblisters"); // Extract info from data-* attributes
    var packcost = button.data("packcost"); // Extract info from data-* attributes
    var blistercost = button.data("blistercost"); // Extract info from data-* attributes
    var totalcost = button.data("totalcost"); // Extract info from data-* attributes
    var markup = button.data("markup"); // Extract info from data-* attributes
    var packselling = button.data("packselling"); // Extract info from data-* attributes
    var blisterselling = button.data("blisterselling"); // Extract info from data-* attributes
    var productid = button.data("productid"); // Extract info from data-* attributes
    var btp = button.data("btp"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".modal-body #myid").val(myid);
    modal.find(".modal-body #batchno").val(batchno);
    modal.find(".modal-body #expiry").val(expiry);
    modal.find(".modal-body #totalpacks").val(totalpacks);
    modal.find(".modal-body #totalblisters").val(totalblisters);
    modal.find(".modal-body #packcost").val(packcost);
    modal.find(".modal-body #blistercost").val(blistercost);
    modal.find(".modal-body #totalcost").val(totalcost);
    modal.find(".modal-body #markuprate").val(markup);
    modal.find(".modal-body #packselling").val(packselling);
    modal.find(".modal-body #blisterselling").val(blisterselling);
    modal.find(".modal-body #blistopack").val(btp);
    $("#produktid")
        .select2({
            dropdownParent: $("#updateInvoiceItem"),
        })
        .val(productid)
        .trigger("change");
});

$("#editProductPrice").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var packprice = button.data("packprice"); // Extract info from data-* attributes
    var blisterprice = button.data("blisterprice"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".modal-body #myid").val(myid);
    modal.find(".modal-body #packprice").val(packprice);
    modal.find(".modal-body #blisterprice").val(blisterprice);
});

$("#supplierReturn").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var packprice = button.data("packprice"); // Extract info from data-* attributes
    var invoiceid = button.data("invoiceid"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".modal-body #myid").val(myid);
    modal.find(".modal-body #packprice").val(packprice);
    modal.find(".modal-body #invoiceid").val(invoiceid);
});

$("#addToCart").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var packprice = button.data("packprice"); // Extract info from data-* attributes
    var blisterprice = button.data("blisterprice"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".modal-body #myid").val(myid);
    modal.find(".modal-body #packprice").val(packprice);
    modal.find(".modal-body #blisterprice").val(blisterprice);
    $("#purchaseformat").select2({
        dropdownParent: $("#addToCart"),
    });
});

$("#updateCart").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var stockid = button.data("stockid"); // Extract info from data-* attributes
    var quantity = button.data("quantity"); // Extract info from data-* attributes
    var trackerid = button.data("trackingid"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".modal-body #myid").val(myid);
    modal.find(".modal-body #quantity").val(quantity);
    modal.find(".modal-body #stockid").val(stockid);
    modal.find(".modal-body #trackerid").val(trackerid);
});
