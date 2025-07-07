<x-layout>
    <button type="hidden" class="d-none" data-bs-toggle="modal" data-bs-target="#loginModal"></button>
    <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input name="email" type="text"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="email@example.com"  value="{{old('email')}}"/>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input name="password" type="password"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" value="Login!">Login!</button>
                        </div>
                        <p class="form-text">
                            Don't have an account yet? Then click <a href="/register">here</a> to create easily an
                            account or use the
                            login
                            methods from below to connect with one of your social media accounts!
                        </p>
                        <p class="form-text">
                            Forgot password? Simply click <a href="/auth/forgot-password">here</a> to create one! Please
                            note you must
                            have
                            created an account previously or logged in via one of your social media accounts!
                        </p>
                    </form>
                    <hr />
                    <div class="d-flex flex-column gap-2">
                        <a class="btn btn-discord" href="/auth/redirect/discord">
                            {{-- <img src={{ asset('images/icons/discord.svg') }} /> --}}
                            Login with Discord!
                        </a>
                        <a class="btn btn-twitch" href="/auth/redirect/twitch">
                            <img src={{ asset('images/icons/twitch.svg') }} />
                            Login with Twitch!
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" href="/">Close</a>
                </div>
            </div>
        </div>
    </div>

</x-layout>
