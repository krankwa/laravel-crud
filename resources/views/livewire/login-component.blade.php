<form wire:submit.prevent="login">
    <div class="mb-3">
        <label for="email">Email</label>
        <input id="email" type="email" wire:model="email" class="form-control" required autofocus>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label for="password">Password</label>
        <input id="password" type="password" wire:model="password" class="form-control" required>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>