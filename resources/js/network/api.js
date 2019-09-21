import request from './request';

export const readUnitKerjaCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/unit_kerja', config);
};

export const createUnitKerja = (submission) => {
    return request.post('/api/unit_kerja', submission);
};

export const updateUnitKerja = (id, submission) => {
    return request.put(`/api/unit_kerja/${id}`, submission);
};

export const deleteUnitKerja = (id) => {
    return request.delete(`/api/unit_kerja/${id}`);
};

export const readSatuanCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/satuan', config);
};

export const createSatuan = (submission) => {
    return request.post('/api/satuan', submission);
};

export const updateSatuan = (id, submission) => {
    return request.put(`/api/satuan/${id}`, submission);
};

export const deleteSatuan = (id) => {
    return request.delete(`/api/satuan/${id}`);
};

export const readKelompokKegiatanCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/kelompok_kegiatan', config);
};

export const createKelompokKegiatan = (submission) => {
    return request.post('/api/kelompok_kegiatan', submission);
};

export const updateKelompokKegiatan = (id, submission) => {
    return request.put(`/api/kelompok_kegiatan/${id}`, submission);
};

export const deleteKelompokKegiatan = (id) => {
    return request.delete(`/api/kelompok_kegiatan/${id}`);
};

export const readKelompokBarangCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/kelompok_barang', config);
};

export const createKelompokBarang = (submission) => {
    return request.post('/api/kelompok_barang', submission);
};

export const updateKelompokBarang = (id, submission) => {
    return request.put(`/api/kelompok_barang/${id}`, submission);
};

export const deleteKelompokBarang = (id) => {
    return request.delete(`/api/kelompok_barang/${id}`);
};

export const readBarangCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/barang', config);
};

export const createBarang = (submission) => {
    return request.post('/api/barang', submission);
};

export const updateBarang = (id, submission) => {
    return request.put(`/api/barang/${id}`, submission);
};

export const deleteBarang = (id) => {
    return request.delete(`/api/barang/${id}`);
};

export const readPerusahaanCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/perusahaan', config);
};

export const createPerusahaan = (submission) => {
    return request.post('/api/perusahaan', submission);
};

export const updatePerusahaan = (id, submission) => {
    return request.put(`/api/perusahaan/${id}`, submission);
};

export const deletePerusahaan = (id) => {
    return request.delete(`/api/perusahaan/${id}`);
};

export const readVolumeDpaCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/volume_dpa', config);
};

export const createVolumeDpa = (submission) => {
    return request.post('/api/volume_dpa', submission);
};

export const updateVolumeDpa = (id, submission) => {
    return request.put(`/api/volume_dpa/${id}`, submission);
};

export const deleteVolumeDpa = (id) => {
    return request.delete(`/api/volume_dpa/${id}`);
};

export const readBarangMasukCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/barang_masuk', config);
};

export const createBarangMasuk = (submission) => {
    return request.post('/api/barang_masuk', submission);
};

export const updateBarangMasuk = (id, submission) => {
    return request.put(`/api/barang_masuk/${id}`, submission);
};

export const deleteBarangMasuk = (id) => {
    return request.delete(`/api/barang_masuk/${id}`);
};
