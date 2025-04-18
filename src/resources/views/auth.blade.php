@extends('templates.main')

@section('title', 'Entrar ou Registrar')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #343a40, #6c757d);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-card {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        padding: 2rem;
    }
    .nav-tabs .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
    }
    .form-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #6c757d;
    }
    .input-with-icon {
        position: relative;
    }
    .input-with-icon input {
        padding-left: 2.5rem;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="auth-card">
                <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                            Login
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
                            Registrar
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="authTabsContent">
                    <!-- Login -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3 input-with-icon">
                                <i class="bi bi-envelope form-icon"></i>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3 input-with-icon">
                                <i class="bi bi-lock form-icon"></i>
                                <input type="password" class="form-control" name="password" placeholder="Senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>

                    <!-- Register -->
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3 input-with-icon">
                                <i class="bi bi-person form-icon"></i>
                                <input type="text" class="form-control" name="name" placeholder="Nome" required>
                            </div>
                            <div class="mb-3 input-with-icon">
                                <i class="bi bi-envelope form-icon"></i>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3 input-with-icon">
                                <i class="bi bi-lock form-icon"></i>
                                <input type="password" class="form-control" name="password" placeholder="Senha" required>
                            </div>
                            <div class="mb-3 input-with-icon">
                                <i class="bi bi-shield-lock form-icon"></i>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Senha" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
