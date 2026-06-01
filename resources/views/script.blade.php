
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
        <script>
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Success!',
            //     text: "{{ session('success') }}",
            //     confirmButtonText: 'OK'
            // });
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "success",
                text: "{{ session('success') }}"
                });
                
        </script>
    @endif

    @if(session('error'))
        <script>
           
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "error",
                text: "{{ session('error') }}"
                });
        </script>
    @endif


<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>


{{-- 
<script>
     function getItemDetails() {

            var itemId  = $("#item_id").val();
            if (itemId) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    
                    type: 'POST',
                    url: "{{url('/ajax/getItems')}}",
                    dataType: 'json',
                    data: {
                        item_id: itemId
                    },
                    
                    success: function (data) {
                            $('#item_name').val(data.item_name);
                            $('#current_qty').val(data.item_qty);
                    }
                });
            }
    }
</script> --}}

<script type="text/javascript">
    
     var Rows1 = 1;
     var SlNo1 = 1;

    function addtogridFun(){
        var grid = document.getElementById('itemgridbody');
        var lastRow = grid.rows.length;
         Rows1 = lastRow + 1;
        var $tr = $("<tr></tr>");
        var item_id = $("#item_id").val();
        var item_name = $("#item_id option:selected").text();
        var sale_qty = $('#sale_qty').val();
        var color = $('#color').val(); 
        var size = $('#size').val(); 
        var price = $('#price').val(); 
        var total_amount = $('#total_amount').val();
        var status = $('#status option:selected').text();



        if (!item_id) {
            alert("Please Select Item")
            $("#item_id").focus();
            return false;

        }

       
        var grid = document.getElementById('itemgridbody');
        var lastRow = grid.rows.length;
        var iteration = lastRow;
        var row = grid.insertRow(lastRow);
        row.setAttribute('id', 'row' + Rows1);
        lastRow++;

        
       
        // first cell  
        var cellLeft = row.insertCell(0);
        var textNode = document.createTextNode('');
        cellLeft.appendChild(textNode);
        cellLeft.innerHTML = Rows1;
        // second cell 

        // var cell2 = row.insertCell(1);
        // var textNode = document.createTextNode('');
        // cell2.appendChild(textNode);
        // cell2.align = "left";
        // cell2.innerHTML = item_code;

        var cell3 = row.insertCell(1);
        var textNode = document.createTextNode('');
        cell3.appendChild(textNode);
        cell3.align = "left";
        cell3.innerHTML = item_name;

        var cell4 = row.insertCell(2);
        var textNode = document.createTextNode('');
        cell4.appendChild(textNode);
        cell4.align = "left";
        cell4.innerHTML = sale_qty;

        var cell45 = row.insertCell(3);
        var textNode = document.createTextNode('');
        cell45.appendChild(textNode);
        cell45.align = "left";
        cell45.innerHTML = size;

        var cell45 = row.insertCell(4);
        var textNode = document.createTextNode('');
        cell45.appendChild(textNode);
        cell45.align = "left";
        cell45.innerHTML = color;

        var cell45 = row.insertCell(5);
        var textNode = document.createTextNode('');
        cell45.appendChild(textNode);
        cell45.align = "left";
        cell45.innerHTML = price;

        var cell45 = row.insertCell(6);
        var textNode = document.createTextNode('');
        cell45.appendChild(textNode);
        cell45.align = "left";
        cell45.innerHTML = total_amount;

        var cell45 = row.insertCell(7);
        var textNode = document.createTextNode('');
        cell45.appendChild(textNode);
        cell45.align = "left";
        cell45.innerHTML = status;

        var cellRight = row.insertCell(8);
        var textNode = document.createTextNode('');
        cellRight.appendChild(textNode);
        cellRight.align = "left";
        cellRight.innerHTML = "<a href='#' id='deleterow' onclick='deleterow(\"row" + Rows1 + "\"," + SlNo1 + ")'>" +"<i class='fa fa-trash'></i>"+"</a>" +
            "<input type='hidden' name='item_id[]' value='" + item_id + "'>" +
            "<input type='hidden' name='size[]' value='" + size + "'>" +
            "<input type='hidden' name='sale_qty[]' value='" + sale_qty + "'>" +
            "<input type='hidden' name='color[]' value='" + color + "'>" +
            "<input type='hidden' name='price[]' value='" + price + "'>" +
            // "<input type='hidden' name='status[]' value='" + status + "'>" +
            "<input type='hidden' name='total_amount[]' value='" + total_amount + "'>" ;
             rowreset();

             document.getElementById("count").value = SlNo1;

                SlNo1++;
                Rows1++;
        }



  function rowreset() {
        $('#size').val("").change();
        $('#item_name').val("").change();
        $('#item_id').val("").change();
        $('#current_qty').val("").change();
        $('#sale_qty').val("").change();
        $('#color').val("").change();
        $('#price').val("").change();
        $('#total_amount').val("").change();


    }


      function deleterow(id, slno) {
        if (confirm("Are you sure you want to delete this Item?")) {
            var r = document.getElementById(id);
            r.parentNode.removeChild(r);
            var tbl = document.getElementById('itemgrid');
            var lastRow = tbl.rows.length;
            for (i = 1; i < lastRow; i++) {
                r = document.getElementById('itemgrid').rows[i];
                r.cells[0].innerHTML = i;
                document.getElementById("count").value = i;
            }
            Rows1--;
        }
    }


 function checkform(actionType = 'save') {
    var count = document.getElementById('count').value;

    if (!count || isNaN(count) || parseInt(count) <= 0) {
        alert("Please Add Something to the Grid");
        return false;
    }

    document.getElementById('action_type').value = actionType;

    let form = document.getElementById('salesubmit');
    form.action = "##";
    form.method = "POST";
    form.submit();

}
  
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.enter-next');

    inputs.forEach((input, index) => {
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (inputs[index + 1]) {
                    inputs[index + 1].focus();
                }
            }
        });
    });
});
</script>
{{-- <script>
    $(document).ready(function (){
        $('#member_id').select2();
    });
</script> --}}

  






