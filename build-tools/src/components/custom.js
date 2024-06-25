document.addEventListener("DOMContentLoaded", function () {
    function quantityProducts() {
        var quantityArrowMinus = document.querySelector(".quantity-arrow-minus");
        var quantityArrowPlus = document.querySelector(".quantity-arrow-plus");
        var quantityNum = document.querySelector(".input-text.qty.text");

        if (quantityArrowMinus && quantityArrowPlus && quantityNum) {
            quantityArrowMinus.addEventListener("click", function (event) {
                event.preventDefault();
                quantityMinus();
            });

            quantityArrowPlus.addEventListener("click", function (event) {
                event.preventDefault();
                quantityPlus();
            });
        }

        function quantityMinus() {
            if (parseInt(quantityNum.value) > 1) {
                quantityNum.value = parseInt(quantityNum.value) - 1;
            }
        }

        function quantityPlus() {
            quantityNum.value = parseInt(quantityNum.value) + 1;
        }
    }

    quantityProducts();
});
