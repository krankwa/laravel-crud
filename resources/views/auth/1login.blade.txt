<form wire:submit.prevent="login">
    <input type="email" wire:model="email" required placeholder="Email">
    <input type="password" wire:model="password" required placeholder="Password">
    <button type="submit">Login</button>
    @error('email') <span>{{ $message }}</span> @enderror
</form>