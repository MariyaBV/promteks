document.addEventListener('DOMContentLoaded', function () {
    // Проверка и установка обработчика для кнопки сохранения PDF
    var saveButton = document.getElementById('save-pdf');
    if (saveButton) {
        saveButton.addEventListener('click', function () {
            var element = document.querySelector('.woocommerce-order');

            var opt = {
                margin: 0.5,
                filename: 'order-details.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // Конвертация HTML в PDF и сохранение
            html2pdf().from(element).set(opt).save();
        });
    }

    // Проверка и установка обработчика для кнопки открытия PDF в новой вкладке
    var printButton = document.getElementById('print-pdf');
    if (printButton) {
        printButton.addEventListener('click', function () {
            var element = document.querySelector('.woocommerce-order');

            var opt = {
                margin: 0.5,
                filename: 'order-details.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // Конвертация HTML в PDF и открытие в новой вкладке
            html2pdf().from(element).set(opt).toPdf().get('pdf').then(function (pdf) {
                var blob = pdf.output('blob');
                var url = URL.createObjectURL(blob);
                window.open(url, '_blank');
            }).catch(function (error) {
                console.error('Error generating PDF:', error);
            });
        });
    }
});
