import request from './request';

export const readBarangMasukCollection = (params) => {
    const config = {
        params,
    };
    return request.get('/api/barang_masuk', config);
};

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
