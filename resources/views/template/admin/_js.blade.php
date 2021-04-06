
<!-- Main JavaScript -->
<script src="{{ asset('templates/vali-admin/js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('templates/vali-admin/js/popper.min.js') }}"></script>
<script src="{{ asset('templates/vali-admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('templates/vali-admin/js/main.js') }}"></script>

<!-- The javascript plugin to display page loading on top -->
<script src="{{ asset('templates/vali-admin/js/plugins/pace.min.js') }}"></script>

<script type="text/javascript">
    $(function(){
        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Button Show Modal Image
    $(document).on("click", ".btn-image", function(e){
        e.preventDefault();
        $("#modal-image").modal("show");
    });

    // Button Delete
    $(document).on("click", ".btn-delete", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask){
            $("#form-delete input[name=id]").val(id);
            $("#form-delete").submit();
        }
    });

    // Button Delete File
    $(document).on("click", ".btn-delete-file", function(e){
        e.preventDefault();
        var url = $(this).data("url");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask){
            $("#form-delete-file input[name=url]").val(url);
            $("#form-delete-file").submit();
        }
    });

    // Button Forbidden
    $(document).on("click", ".btn-forbidden", function(e){
        e.preventDefault();
        alert("Anda tidak mempunyai akses untuk membuka halaman ini!");
    });

    // Button Disabled
    $(document).on("click", ".btn-disabled", function(e){
        e.preventDefault();
        alert("Tombol ini tidak ada fungsinya!");
    });

    // Button Toggle Password
    $(document).on("click", ".btn-toggle-password", function(e){
        e.preventDefault();
        if(!$(this).hasClass("show")){
            $(this).parents(".form-group").find("input[type=password]").attr("type","text");
            $(this).find(".fa").removeClass("fa-eye").addClass("fa-eye-slash");
            $(this).addClass("show");
        }
        else{
            $(this).parents(".form-group").find("input[type=text]").attr("type","password");
            $(this).find(".fa").removeClass("fa-eye-slash").addClass("fa-eye");
            $(this).removeClass("show");
        }
    });
    
    // Input Hanya Nomor
    $(document).on("keypress", ".number-only", function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode >= 48 && charCode <= 57) { 
            // 0-9 only
            return true;
        }
        else{
            return false;
        }
    });
    // End Input Hanya Nomor

    // Input Format Ribuan
    $(document).on("keyup", ".thousand-format", function(){
        var value = $(this).val();
        $(this).val(thousand_format(value, ""));
    });
    // End Input Format Ribuan

    // Functions
    function thousand_format(angka, prefix){
        var number_string = angka.replace(/\D/g,'');
        number_string = (number_string.length > 1) ? number_string.replace(/^(0+)/g, '') : number_string;
        var split = number_string.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/gi);
     
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
     
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
</script>