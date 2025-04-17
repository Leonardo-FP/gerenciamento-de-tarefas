@extends('templates.main')

@include('partials.navbar')

{{-- Estrutura de Toast genérico para notificar usuários --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="toastFeedback"
         class="toast align-items-center text-bg-success border-0 position-relative overflow-hidden"
         role="alert" aria-live="assertive" aria-atomic="true"
         data-bs-delay="3000" data-bs-autohide="true">
        
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
        </div>
        
        <div class="toast-timer position-absolute bottom-0 start-0"></div>
    </div>
</div>