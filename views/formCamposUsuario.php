
<div class="mb-3">
    <label for="nome" class="form-label">Nome Completo:</label>
    <input type="text" class="form-control" id="nome" name="nome" required value="<?= isset($usuario['nome']) ? htmlspecialchars($usuario['nome']) : '' ?>">
</div>
<div class="mb-3">
    <label for="email" class="form-label">E-mail:</label>
    <input type="email" class="form-control" id="email" name="email" required value="<?= isset($usuario['email']) ? htmlspecialchars($usuario['email']) : '' ?>">
</div>
<div class="mb-3">
    <label for="senha" class="form-label">Senha:</label>
    <input type="password" class="form-control" id="senha" name="senha" <?= isset($usuario) ? '' : 'required' ?>>

</div></div>