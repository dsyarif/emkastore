<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang_tb';
    protected $primaryKey       = 'id_barang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_barang', 'id_supplier', 'id_kategori', 'id_sub_kategori', 'nm_barang', 'harga_beli', 'harga_jual'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function kode_produk()
    {
        $builder = $this->db->table($this->table);
        $builder->select('COUNT(*) AS jumlah');
        $count = $builder->get()->getRowArray();

        $nextCode = $count['jumlah'] + 1;

        // Define your code structure here (prefix, padding)
        $prefix = "BRG-";
        $paddedCode = str_pad($nextCode, 5, "0", STR_PAD_LEFT);

        return $prefix . $paddedCode;
    }
}
