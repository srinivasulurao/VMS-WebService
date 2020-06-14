<form method='post' onsubmit="submitVoucherForm(event);" class='voucher-input-form' id='voucher-input-form' >
    <h4>Input your voucher code</h4>
        <div class="form-group">
           <label for='vouchers_textarea'>Enter your vouchers (Ex: abc,xyz)</label>
           <textarea class="form-control" id='vouchers_textarea' name="vouchers_textarea"><?php echo $vouchers; ?></textarea> 
           <input type='hidden' name='csrf_token' id='csrf_token' value="<?php echo csrf_token(); ?>" >
           <span id='error_text' class='error_text'></span>
           <button type='submit' name='submit_vouchers' class='btn btn-info float-right' id='submit_vouchers' style='margin-top:10px'>
            <i id='loading' class="fa fa-spin fa-spinner" aria-hidden="true"></i> Next
           </button>  
        </div><br>
  </form>