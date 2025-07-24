<button wire:click="logout" 
        class="btn btn-outline-danger btn-sm" 
        wire:confirm="Are you sure you want to logout?"
        wire:loading.attr="disabled">
    <span wire:loading.remove>
        <i class="bi bi-box-arrow-right"></i> Logout
    </span>
    <span wire:loading>
        <span class="spinner-border spinner-border-sm" role="status"></span>
        Logging out...
    </span>
</button>
