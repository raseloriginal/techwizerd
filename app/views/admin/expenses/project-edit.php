<?php $title = 'Edit Project Expense'; ?>

<div class="flex items-center gap-2 mb-6">
    <a href="<?= base_url('admin/expenses/project') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
    <h2 class="text-2xl font-bold text-gray-800 m-0">Edit Project Expense</h2>
</div>

<form action="<?= base_url('admin/expenses/project/edit/' . $expense['id']) ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-4xl">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b border-gray-100 pb-6">
        <div class="form-group mb-0">
            <label for="project_id" class="form-label">Project <span class="text-red-500">*</span></label>
            <select id="project_id" name="project_id" class="form-control font-semibold" required>
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id'] ?>" <?= ($expense['project_id'] == $project['id']) ? 'selected' : '' ?>>
                        <?= h($project['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group mb-0">
            <label for="category_id" class="form-label">Expense Category</label>
            <select id="category_id" name="category_id" class="form-control">
                <option value="">Uncategorized</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($expense['category_id'] == $cat['id']) ? 'selected' : '' ?>><?= h($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="title" class="form-label">Expense Title / Description <span class="text-red-500">*</span></label>
        <input type="text" id="title" name="title" class="form-control" required value="<?= h($expense['title']) ?>">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="form-group mb-0">
            <label for="amount" class="form-label">Amount (BDT) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" id="amount" name="amount" class="form-control font-mono text-lg text-orange-600 font-bold" required value="<?= h($expense['amount']) ?>">
        </div>
        
        <div class="form-group mb-0">
            <label for="expense_date" class="form-label">Date <span class="text-red-500">*</span></label>
            <input type="date" id="expense_date" name="expense_date" class="form-control" required value="<?= h($expense['expense_date']) ?>">
        </div>
        
        <div class="form-group mb-0">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="pending" <?= $expense['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= $expense['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= $expense['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="form-group mb-0">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select id="payment_method" name="payment_method" class="form-control">
                <?php
                $methods = ['cash'=>'Cash', 'bank_transfer'=>'Bank Transfer', 'mobile_banking'=>'Mobile Banking', 'cheque'=>'Cheque'];
                foreach ($methods as $k => $v) {
                    $sel = $expense['payment_method'] === $k ? 'selected' : '';
                    echo "<option value=\"$k\" $sel>$v</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group mb-0">
            <label for="reference" class="form-label">Reference / TrxID / Cheque No.</label>
            <input type="text" id="reference" name="reference" class="form-control" value="<?= h($expense['reference'] ?? '') ?>">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b border-gray-100 pb-6">
        <div class="form-group mb-0">
            <label for="paid_to" class="form-label">Paid To (Vendor/Person)</label>
            <input type="text" id="paid_to" name="paid_to" class="form-control" value="<?= h($expense['paid_to'] ?? '') ?>">
        </div>
        
        <div class="form-group mb-0">
            <label for="paid_by" class="form-label">Paid By (Employee)</label>
            <input type="text" id="paid_by" name="paid_by" class="form-control" value="<?= h($expense['paid_by'] ?? '') ?>">
        </div>
    </div>

    <div class="form-group mb-8">
        <label class="form-label mb-2">Receipt / Invoice Document</label>
        
        <?php if (!empty($expense['receipt_image'])): ?>
            <div class="mb-3 flex items-center gap-4 bg-gray-50 p-3 rounded border border-gray-200">
                <a href="<?= upload_url($expense['receipt_image']) ?>" target="_blank" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold text-sm">
                    <i data-lucide="file-text" class="w-5 h-5"></i> View Current Receipt
                </a>
                <label class="flex items-center gap-2 text-red-600 hover:text-red-800 font-semibold text-sm cursor-pointer ml-auto">
                    <input type="checkbox" name="delete_receipt" value="1" class="rounded border-gray-300"> Delete
                </label>
            </div>
        <?php endif; ?>

        <input type="file" name="receipt" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" accept=".jpg,.jpeg,.png,.pdf">
        <div class="text-xs text-gray-400 mt-1">Upload new file to replace existing. Accepts PDF, JPG, PNG up to 5MB</div>
    </div>

    <div class="flex justify-end gap-4">
        <button type="submit" class="btn-primary flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Update Expense
        </button>
    </div>
</form>
