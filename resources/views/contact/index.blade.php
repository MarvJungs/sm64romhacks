<x-layout>
    <h1>Contact Form</h1>
    <p>
        You got any sort of feedback, have feature requests or found an issue/bug? Feel free to use this Form for these things!
    </p>
    <p>
        We will take a look at the feedback very closely and decide how we will handle it!
    </p>

    <form class="row g-3" method="post" action="{{ route('contact.send') }}">
        @csrf
        <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" required value="{{ $user->global_name }}"
                @disabled(true)>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" required value="{{ $user->email }}"
                @disabled(true)>
        </div>
        <div class="col-12">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" required>
          </div>
        
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" name="message" rows="10" required></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
    </form>
</x-layout>
