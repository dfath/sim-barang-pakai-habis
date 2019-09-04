import request from './request';

export const fetchListBarangMasuk = () => {
  return request.get('/api/barang_masuk');
};
