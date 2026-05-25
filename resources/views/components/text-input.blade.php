@props(['disabled' => false])

<style>
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-text-fill-color: white !important;
        -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* Принудительно показываем курсор (каретку) белым цветом сразу при фокусе */
    input {
        caret-color: white !important;
    }
</style>

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'bg-transparent border-white border-2 text-white focus:border-white focus:ring-0 py-3 px-4 w-full transition-all duration-300 placeholder:text-white/20 outline-none'
]) !!} style="background-color: transparent !important; color: white !important;">
