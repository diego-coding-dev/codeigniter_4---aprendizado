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

                <?php if (session()->has('additionalData_product') || session()->has('dataProductType_product') || session()->has('dataBrand_product') || session()->has('dataDepartment_product')) : ?>

                    <?php if (session()->has('dataProductType_product')) : ?>

                        <label><strong>Tipo do produto:</strong>&nbsp;<?php echo esc(session('dataProductType_product.description')); ?></label>

                    <?php endif; ?>

                    <br>

                    <?php if (session()->has('dataBrand_product')) : ?>

                        <label><strong>Marca:</strong>&nbsp;<?php echo esc(session('dataBrand_product.description')); ?></label>

                    <?php endif; ?>

                    <br>

                    <?php if (session()->has('additionalData_product')) : ?>

                        <label><strong>Descrição:</strong>&nbsp;<?php echo esc(session('additionalData_product.description')); ?></label>
                        <br>
                        <label><strong>Preço de custo:</strong>&nbsp;R$&nbsp;<?php echo esc(session('additionalData_product.cost_price')); ?></label>
                        <br>
                        <label><strong>Preço de venda:</strong>&nbsp;R$&nbsp;<?php echo esc(session('additionalData_product.sale_price')); ?></label>
                        <br>

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