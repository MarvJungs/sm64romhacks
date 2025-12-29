<x-layout>
    <form method="post" action="/email/verification-notification">
        @csrf
        <p>Your Account needs to be verified. Please check your mailbox to verify it.</p>
        <p class="text-info">Didn't get an email? Press the button below and we will resend you your verificationlink!
        </p>
        <p class="text-warning">Please make sure to also check your spam folder.</p>
        <button class="btn btn-primary" type="submit">Resend Email-Verificationlink</button>
    </form>
</x-layout>
