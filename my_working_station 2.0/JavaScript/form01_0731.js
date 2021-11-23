// get input
const userName = document.getElementsByName("userName");
const telNumber = document.getElementsByName("telNumber");
const userMail = document.getElementsByName("userMail");
const orderDate = new Date().getTime("orderDate");
const vage = document.getElementsByName("vage");
const store = document.getElementsByName("store");
const totalOrder = document.getElementsByName("totalOrder");
const note = document.getElementsByName("note");
const beverage = document.getElementsByName("beverage");
let choice = [];
choice = document.getElementsByName("choice[]");
const noteBeverage = document.getElementsByName("noteBeverage");
const location = document.getElementsByName("location");

// submit

btnSuccess.addEventListener("click, addForm");

function addForm() {
    let person = {
        name = userName.values,
        phone = telNumber.values,
        mail = userName.values,
    };
    let date = orderDate.toString;
    let meal = {
        ifVage = vage.values,
        restaurant = store.values,
        amount = totalOrder.values,
        request = note.toString,
    };
    let drinkOrNot = {
        will = beverage.values,
        addOn = choice.values,
        request = noteBeverage.toString,
    };
    let take = location.toString;

    updateForm();
};

function updateForm() {
    // 待完成
};

// clear form

btnClear.addEventListener("click, clearForm");

function clearForm(e) {
    if (click === true) {
        e.preventDefault();
    };
};