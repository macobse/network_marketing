    </div>
    <!-- /container -->
   </div>
    <!-- /wrapper -->
<!-- jQuery library -->

 
<!-- bootstrap JavaScript -->

<script src="../../libs/css/bootstrap/docs-assets/js/holder.js"></script>


>
<!-- bootbox library -->
<script src="../../libs/js/bootbox.min.js"></script>



 <script src="../../libs/js/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../libs/js/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../libs/js/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../../libs/js/raphael/raphael.min.js"></script>
    <script src="../../libs/js/morrisjs/morris.min.js"></script>
    <script src="../../libs/js/data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../libs/js/sb-admin/sb-admin-2.js"></script>
<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
 <script>
// JavaScript for deleting product
$(document).on('click', '.delete-object', function(){
 
    var id = $(this).attr('delete-id');
 
    bootbox.confirm({
        message: "<h4>Are you sure?</h4>",
        buttons: {
            confirm: {
                label: '<span class="glyphicon glyphicon-ok"></span> Yes',
                className: 'btn-danger'
            },
            cancel: {
                label: '<span class="glyphicon glyphicon-remove"></span> No',
                className: 'btn-primary'
            }
        },
        callback: function (result) {
 
            if(result==true){
                $.post('delete_product.php', {
                    object_id: id
                }, function(data){
                    location.reload();
                }).fail(function() {
                    alert('Unable to delete.');
                });
            }
        }
    });
 
    return false;
});
</script>
</body>
</html>