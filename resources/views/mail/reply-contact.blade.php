
@extends('mail.template')
@section('contentEmail')
<div class="containter">
    <h3>Thân gửi {{ $userName }},</h3>
    <div>
        <div>
            Chúng tôi có nhận được thông báo liên hệ của bạn trên hệ thống của chúng tôi. Chúng tôi đã đọc thông tin bạn cung cấp
            và chúng tôi xin trả lời bạn như sau. 
        </div>
        <div>
            {!! $content !!}
        </div>
    </div>
    <div class="footer">
        <span> Cảm ơn bạn đã đọc thông báo này. Vui lòng không chia sẻ thông báo này cho bất kỳ ai!</span>
        <div class="footer-sign">Quản lý trang báo mới</div>
    </div>
</div>
@stop
