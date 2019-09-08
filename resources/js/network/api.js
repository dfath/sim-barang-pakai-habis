import request from './request';

export const fetchListBarangMasuk = (params) => {
    const config = {
        params,
    };
    return request.get('/api/barang_masuk', config);
};

export const fetchListUnitKerja = (params) => {
    const config = {
        params,
    };
    return request.get('/api/unit_kerja', config);
};
