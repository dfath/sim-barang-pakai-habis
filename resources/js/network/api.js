import request from './request';

export const fetchListBarangMasuk = (params) => {
    const config = {
        params,
    };
    return request.get('/api/barang_masuk', config);
};
