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
                <?php if (session()->has('dataProvider_acquisition') || session()->has('dataProducts_acquisition')) : ?>

                    <?php if (session()->has('dataProvider_acquisition')) : ?>
                        <label><strong>Fornecedor selecionado:</strong>&nbsp;<?php echo esc(session('dataProvider_acquisition.corporate_name')); ?></label>
                    <?php endif; ?>
                    <br>
                    <?php if (session()->has('dataProducts_acquisition')) : ?>
                        <label><strong>Produtos na lista:</label>
                        <?php foreach (session()->get('dataProducts_acquisition') as $product) : ?>
                            <h5>&nbsp;-&nbsp;<?php echo $product['description']; ?></h5>
                        <?php endforeach; ?>
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