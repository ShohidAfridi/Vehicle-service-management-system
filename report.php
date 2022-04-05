<?php 
require_once('config.php');
include_once('space.php');
?>

<style>
    #uni_modal .modal-footer{
        display:none
    }
    span.select2-selection.select2-selection--single,span.select2-selection.select2-selection--multiple {
    padding: 0.25rem 0.5rem;
    min-height: calc(1.5em + 0.5rem + 2px);
    height:auto !important;
    max-height:calc(3.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0;
}
</style>
<section class="py-2">
<div class="container">
    <form action="" id="request_form">
        <input type="hidden" name="id">
    <div class="col-12">
        <div class="row">
            
                <div class="form-group">
                    <label for="owner_name" class="control-label">Your Fullname</label>
                    <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" required>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Your Contact #</label>
                    <input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" required>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Your Email</label>
                    <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" required>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label">Comment</label>
                    <textarea rows="3" name="address" id="address" class="form-control form-control-sm rounded-0" style="resize:none" required></textarea>
                </div>
            </div>
                <div class="form-group" style="display:none">
                    <label for="pickup_address" class="control-label">Pick up Address</label>
                    <textarea rows="3" name="pickup_address" id="pickup_address" class="form-control form-control-sm rounded-0" style="resize:none" required></textarea>
                </div>
            </div>
        </div>
    </div>
        <div class="w-100 d-flex justify-content-end mx-2">
            <div class="col-auto">
                <button class="btn btn-primary btn-sm rounded-0">Submit Report</button>
            </div>
        </div>
    </form>
</div>
</section>
<script>
    $(function(){
        $('.select2').select2({
            placeholder:"Please Select Here",
            dropdownParent: $('#uni_modal')
        })
        $('#service_type').change(function(){
            var type = $(this).val().toLowerCase()
            if(type == 'pick up'){
                $('#pickup_address').parent().show()
                $('#pickup_address').attr('required',true)
            }else{
                $('#pickup_address').parent().hide()
                $('#pickup_address').attr('required',false)
            }
                
        })
        $('#request_form').submit(function(e){
            e.preventDefault()
            start_loader();
            $.ajax({
                url:'classes/Master.php?f=save_request',
                method:'POST',
                data:$(this).serialize(),
                dataType:'json',
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured",'error');
                    end_loader()
                },
                success:function(resp){
                    end_loader()
                    if(resp.status == 'success'){
                        $('#uni_modal').on('hidden.bs.modal', function(){
                            if($(this).find('#request_form').length > 0){
                                setTimeout(() => {
                                    uni_modal("","success_msg.php")
                                }, 200);
                            }
                        })
                        $('#uni_modal').modal('hide')
                    }else{
                        alert_toast("An error occured",'error');
                    }
                }
            })
        })
    })
</script>