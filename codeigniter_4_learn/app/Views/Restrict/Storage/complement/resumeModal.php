<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="fas fa-fw fa-list-alt fa-lg"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Resumo</h5>
            </div>
            <div class="modal-body">
                <?php if (session()->has('dataProvider_storage')) : ?>

                    <?php if (session()->has('dataProvider_storage')) : ?>
                        <label><strong>Fornecedor:</strong>&nbsp;<?php echo esc(session('dataProvider_storage.corporate_name')); ?></label>
                    <?php endif; ?>
                    <br>
                    <?php if (session()->has('dataProduct_storage')) : ?>
                        <label><strong>Produto:</strong>&nbsp;<?php echo esc(session('dataProduct_storage.description')); ?></label>
                    <?php endif; ?>

                <?php else : ?>

                    <h5>Nenhum dado adicionado.</h5>

                <?php endif; ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>