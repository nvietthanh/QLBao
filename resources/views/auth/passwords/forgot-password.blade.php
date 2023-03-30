<div>
    <h3>Chào bạn {{ $account->accountProfile->getFullName() }}</h3>
    <div class="main">
        <div>
            Chúng tôi có nhận được thông báo yêu cầu thay đổi mật khẩu do bạn gửi vài phút trước. 
        </div>
        <div>
            Đây là mã OTP giúp bạn thay đổi mật khẩu, vui lòng nhập mã OTP 
                <span class="text-otp">{{ $account->otp }}</span> để thay đổi mật khẩu.
        </div>
        <div>Mã OTP có thời hạn 5 phút.</div>
    </div>
    <div class="footer">
        <span> Cảm ơn bạn đã đọc thông báo này. Vui lòng không chia sẻ thông báo này cho bất kỳ ai.</span>
        <div><b>Quản lý trang báo mới</b></div>
    </div>
</div>
<style>
    .main {
        font-size: 18px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .text-otp {
        font-size: 18px;
        background-color: blanchedalmond;
    }
    .footer {
        font-size: 24px;
    }
</style>