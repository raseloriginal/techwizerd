<?php $title = 'Record Project Expense'; ?>

<div class="flex items-center gap-2 mb-6">
    <a href="<?= base_url('admin/expenses/project') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
    <h2 class="text-2xl font-bold text-gray-800 m-0">Record Project Expense</h2>
</div>

<form action="<?= base_url('admin/expenses/project/create') ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-4xl">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b border-gray-100 pb-6">
        <div class="form-group mb-0">
            <label for="project_id" class="form-label">Project <span class="text-red-500">*</span></label>
            <select id="project_id" name="project_id" class="form-control font-semibold" required>
                <option value="">Select a Project</option>
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id'] ?>" <?= ($projectId == $project['id']) ? 'selected' : '' ?>>
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
                    <option value="<?= $cat['id'] ?>"><?= h($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="title" class="form-label">Expense Title / Description <span class="text-red-500">*</span></label>
        <input type="text" id="title" name="title" class="form-control" required placeholder="e.g. Material Purchase from Vendor X">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="form-group mb-0">
            <label for="amount" class="form-label">Amount (BDT) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" id="amount" name="amount" class="form-control font-mono text-lg text-orange-600 font-bold" required>
        </div>
        
        <div class="form-group mb-0">
            <label for="expense_date" class="form-label">Date <span class="text-red-500">*</span></label>
            <input type="date" id="expense_date" name="expense_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        
        <div class="form-group mb-0">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="approved" selected>Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="form-group mb-0">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select id="payment_method" name="payment_method" class="form-control">
                <option value="cash">Cash</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="mobile_banking">Mobile Banking (bkash/Nagad)</option>
                <option value="cheque">Cheque</option>
            </select>
        </div>
        
        <div class="form-group mb-0">
            <label for="reference" class="form-label">Reference / TrxID / Cheque No.</label>
            <input type="text" id="reference" name="reference" class="form-control" placeholder="Optional">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b border-gray-100 pb-6">
        <div class="form-group mb-0">
            <label for="paid_to" class="form-label">Paid To (Vendor/Person)</label>
            <input type="text" id="paid_to" name="paid_to" class="form-control">
        </div>
        
        <div class="form-group mb-0">
            <label for="paid_by" class="form-label">Paid By (Employee)</label>
            <input type="text" id="paid_by" name="paid_by" class="form-control">
        </div>
    </div>

    <div class="form-group mb-8">
        <label for="receipt" class="form-label mb-2">Receipt / Invoice Document</label>
        <input type="file" id="receipt" name="receipt" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" accept=".jpg,.jpeg,.png,.pdf">
        <div class="text-xs text-gray-400 mt-1">Accepts PDF, JPG, PNG up to 5MB</div>
    </div>

    <div class="flex justify-end gap-4">
        <a href="<?= base_url('admin/expenses/project') ?>" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">Cancel</a>
        <button type="submit" class="btn-primary flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Save Expense
        </button>
    </div>
</form>
