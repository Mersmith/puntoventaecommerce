<div>
    <!--ESTADO-->
    <div>
        <p>Estado del producto: </p>
        <div>
            <label>
                <input type="radio" value="0" name="estado" wire:model.defer="estado">
                Desactivado
            </label>
            <label>
                <input type="radio" value="1" name="estado" wire:model.defer="estado">
                Activado
            </label>
        </div>
        @error('estado')
            <span>{{ $message }}</span>
        @enderror
    </div>
    <!--Enviar-->
    <div>
        <button wire:click="actualizarEstadoProducto" wire:loading.attr="disabled"
            wire:target="actualizarEstadoProducto">
            Actualizar estado
        </button>
    </div>
</div>
