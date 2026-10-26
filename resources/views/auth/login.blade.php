<x-layout>
    <x-form title="Log In" description="Glad to have you back.">
        <form action="/login" method="POST" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="Email" name="email" type="email" />
            <x-form.field label="Password" name="password" type="password" />

            <button type="submit" class="btn mt-2 h-10 w-full" data-test="login-button">Sign In</button>

        </form>
    </x-form>
</x-layout>