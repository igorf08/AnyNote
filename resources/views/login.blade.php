@extends('layouts.main_layout')
@section('content')
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">
                    
                    <!-- logo -->
                    <div class="text-center p-3">
                        <img src="assets/images/logo.png" alt="Notes logo">
                    </div>

                    <!-- form -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="/loginSubmit" method="post" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label for="text_username" class="form-label">Usuário</label>
                                    <input type="email" class="form-control bg-dark text-info" name="text_username" value="{{ old('text_username') }}" required>
                                    @error('text_username')
                                        <div class="text-danger">{{ $message }}</div>                                        
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="text_password" class="form-label">Senha</label>
                                    <input type="password" class="form-control bg-dark text-info" name="text_password" value="{{ old('text_password') }}" required>
                                    @error('text_password') 
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-secondary w-100">Entrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- Invalid Login --}}
                    @if (session('loginError'))
                        <div class="alert alert-danger text-center">
                            {{ session('loginError') }}
                        </div>
                    @endif
                    <!-- copy -->
                    <div class="flex flex-col text-center text-secondary mt-3 ">
                        <small>&copy; {{ date('M - Y') }}</small>
                        <small>Notes</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
