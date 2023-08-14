var names = [];
var orders = [];
var addons = [];
var size = [];
var quantity = [];
var totalPrice = [];
var n = 1;
var x = 0;
var selectedRow = null;

function AddRow() {
  var AddRowN = document.getElementById("pendingOrdersDetails");

  if (
    document.getElementsByName("name")[0].value != "" &&
    document.getElementsByName("order")[0].value != "" &&
    document.getElementsByName("addons")[0].value != "" &&
    document.getElementsByName("size")[0].value != "" &&
    document.getElementsByName("quantity")[0].value != ""
  ) {
    if (selectedRow == null) {
      var NewRow = AddRowN.insertRow(n);

      names[x] = document.getElementsByName("name")[0].value;
      orders[x] = document.getElementsByName("order")[0].value;
      addons[x] = document.getElementsByName("addons")[0].value;
      size[x] = document.getElementsByName("size")[0].value;
      quantity[x] = document.getElementsByName("quantity")[0].value;

      var cel1 = NewRow.insertCell(0);
      var cel2 = NewRow.insertCell(1);
      var cel3 = NewRow.insertCell(2);
      var cel4 = NewRow.insertCell(3);
      var cel5 = NewRow.insertCell(4);
      var cel6 = NewRow.insertCell(5);
      var cel7 = NewRow.insertCell(6);

      cel1.innerHTML = names[x];
      cel2.innerHTML = orders[x];
      cel3.innerHTML = addons[x];
      cel4.innerHTML = size[x];
      cel5.innerHTML = quantity[x];
      cel6.innerHTML = "";
      cel7.innerHTML =
        "<button onclick='onDelete(this)' style='margin-top:5px' class='btn-danger btn'>Delete</button> <button onclick='onEdit(this)' style='margin-top:5px' class='btn-warning btn'>Edit</button>";

      n++;
      x++;

      resetForm();
    } else {

      selectedRow.cells[0].innerHTML =
        document.getElementsByName("name")[0].value;
      selectedRow.cells[1].innerHTML =
        document.getElementsByName("order")[0].value;
      selectedRow.cells[2].innerHTML =
        document.getElementsByName("addons")[0].value;
      selectedRow.cells[3].innerHTML =
        document.getElementsByName("size")[0].value;
      selectedRow.cells[4].innerHTML =
        document.getElementsByName("quantity")[0].value;

        names[selectedRow.rowIndex - 1] = document.getElementsByName("name")[0].value;
        orders[selectedRow.rowIndex - 1] = document.getElementsByName("order")[0].value;
        addons[selectedRow.rowIndex - 1] = document.getElementsByName("addons")[0].value;
        size[selectedRow.rowIndex - 1] = document.getElementsByName("size")[0].value;
        quantity[selectedRow.rowIndex - 1] = document.getElementsByName("quantity")[0].value;

      resetForm();
    }
  } else {
    alert("Fill out the form first");
  }
}

function jsArrayToPhp() {
  if (
    names.length === 0 &&
    orders.length === 0 &&
    size.length === 0 &&
    addons.length === 0 &&
    quantity.length === 0
  ) {
    alert("No orders added. Please add orders first.");
    return false; // Prevent form submission
  }

  // If 'names' array is not empty, proceed with form submission
  document.getElementById("hiddenNames").value = JSON.stringify(names);
  document.getElementById("hiddenOrders").value = JSON.stringify(orders);
  document.getElementById("hiddenSize").value = JSON.stringify(size);
  document.getElementById("hiddenAddons").value = JSON.stringify(addons);
  document.getElementById("hiddenQuantity").value = JSON.stringify(quantity);
  return true; // Allow form submission
}

function changeOrdersValue(val) {
  document.getElementById("order").value = val;
}

function showOptions() {
  document.getElementById("container2").style.visibility = "visible";
}

function hideOptions() {
  document.getElementById("container2").style.visibility = "hidden";
}

function onEdit(td) {
  selectedRow = td.parentElement.parentElement;

  document.getElementsByName("name")[0].value = selectedRow.cells[0].innerHTML;
  document.getElementsByName("order")[0].value = selectedRow.cells[1].innerHTML;
  document.getElementsByName("addons")[0].value = selectedRow.cells[2].innerHTML;
  document.getElementsByName("size")[0].value = selectedRow.cells[3].innerHTML;
  document.getElementsByName("quantity")[0].value = selectedRow.cells[4].innerHTML;
  document.querySelector(".num").value = selectedRow.cells[4].innerHTML;

}

function resetForm() {
  document.getElementsByName("name")[0].value = "";
  document.getElementsByName("order")[0].value = "";
  document.getElementsByName("addons")[0].value = "";
  document.getElementsByName("size")[0].value = "";
  document.getElementsByName("quantity")[0].value = "";

  selectedRow = null;
}

function onDelete(td) {
  row = td.parentElement.parentElement;

  alert(row.rowIndex);

  names.splice(row.rowIndex - 1, 1);
  orders.splice(row.rowIndex - 1, 1);
  size.splice(row.rowIndex - 1, 1);
  addons.splice(row.rowIndex - 1, 1);
  quantity.splice(row.rowIndex - 1, 1);

  document.getElementById("pendingOrdersDetails").deleteRow(row.rowIndex);

  resetForm();
  n--;
  x--;
}



