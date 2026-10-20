 <!--   Core JS Files   -->
 <script src="/assets/js/core/jquery-3.7.1.min.js"></script>
 <script src="/assets/js/core/popper.min.js"></script>
 <script src="/assets/js/core/bootstrap.min.js"></script>

 <!-- jQuery Scrollbar -->
 <script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
 <!-- Datatables -->
 <script src="/assets/js/plugin/datatables/datatables.min.js"></script>
 <!-- Kaiadmin JS -->
 <script src="/assets/js/kaiadmin.min.js"></script>
 <!-- Kaiadmin DEMO methods, don't include it in your project! -->
 <script src="/assets/js/setting-demo2.js"></script>
 <script>
     $(document).ready(function() {
         $("#basic-datatables").DataTable({});

         $("#multi-filter-select").DataTable({
             pageLength: 5,
             initComplete: function() {
                 this.api()
                     .columns()
                     .every(function() {
                         var column = this;
                         var select = $(
                                 '<select class="form-select"><option value=""></option></select>'
                             )
                             .appendTo($(column.footer()).empty())
                             .on("change", function() {
                                 var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                 column
                                     .search(val ? "^" + val + "$" : "", true, false)
                                     .draw();
                             });

                         column
                             .data()
                             .unique()
                             .sort()
                             .each(function(d, j) {
                                 select.append(
                                     '<option value="' + d + '">' + d + "</option>"
                                 );
                             });
                     });
             },
         });

         // Add Row
         $("#add-row").DataTable({
             pageLength: 5,
         });

       
     });

 </script>
 {{-- <script>
    // Đoạn mã xử lý lịch
    function toggleFields() {
        var isDiscountSelected = document.getElementById('GiamTien').checked;
        var discountField = document.getElementById('discountField');
        var giftProductField = document.getElementById('giftProductField');

        if (isDiscountSelected) {
            discountField.disabled = false;
            giftProductField.disabled = true;
        } else {
            discountField.disabled = true;
            giftProductField.disabled = false;
        }
    }
    window.onload = function() {


        toggleFields();

        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var year = today.getFullYear();
        var formattedDate = year + '-' + month + '-' + day;

        document.getElementById('NgayBD').setAttribute('min', formattedDate);
        document.getElementById('NgayKT').setAttribute('min', formattedDate);

        document.getElementById('NgayBD').addEventListener('change', function() {
            var startDate = this.value;
            if (startDate) {
                document.getElementById('NgayKT').setAttribute('min', startDate);
            }
        });

        // Đoạn mã hiển thị modal nếu có lỗi
        <?php if ($showModal): ?>
            $('#addRowModal').modal('show');
        <?php endif; ?>
    };
</script> --}}

<!-- <script>
    function toggleFields() {
        var isDiscountSelected = document.getElementById('GiamTien').checked;
        var discountField = document.getElementById('discountField');
        var giftProductField = document.getElementById('giftProductField');

        if (isDiscountSelected) {
            discountField.disabled = false;
            giftProductField.disabled = true;
        } else {
            discountField.disabled = true;
            giftProductField.disabled = false;
        }
    }

    window.onload = function() {
        toggleFields();
    };
</script> -->



