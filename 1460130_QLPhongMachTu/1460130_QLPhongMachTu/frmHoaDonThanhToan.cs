using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Data.SqlClient;
using Microsoft.VisualBasic;
using System.Collections;
using System.Diagnostics;
using System.Xml;
using System.IO;
using System.Configuration;

namespace _1460130_QLPhongMachTu
{
    public partial class frmHoaDonThanhToan : Form
    {
        static DataConnect dp = new DataConnect();
        int chay = 0;
        public frmHoaDonThanhToan()
        {
            InitializeComponent();
        }

        private void frmHoaDonThanhToan_Load(object sender, System.EventArgs e)
        {
            LoadCboNgayChon();
            LoadDSDaXuat();
        }

        private void LoadCboNgayChon()
        {
            DataTable dt = new DataTable();
            dt = dp.FillBang("select distinct (CONVERT(DATE , NgayKham)) as NgayKham from PhieuKhamBenh order by NgayKham");
            cboChonNgay.DataSource = dt;
            cboChonNgay.DisplayMember = "NgayKham";
            chay = 1;
            //cboChonNgay.ValueMember = "ID";
        }

        private void cboChonNgay_SelectedIndexChanged(object sender, System.EventArgs e)
        {
            if (chay == 0)
                return;
            LoadDSCanXuat();
            XoaTrang();
        }

        private void XoaTrang()
        {
            txtHoTen.Text = "";
            txtNgay.Text = "";
            txtTienKham.Text = "40000";
            txtTienThuoc.Text = "0";
        }

        private void LoadDSCanXuat()
        {
            string[] str = new string[] { "@NgayKham" };
            object[] val = new object[] { DateTime.Parse(cboChonNgay.Text) };
            DataTable dtBenhNhan = new DataTable();
            dtBenhNhan = dp.ReadDataAddPram("sp_ReadLayDSBenhNhanCanXuatTheoNgay", str, val, 100);
            int i = 1;
            dgvBenhNhan.Rows.Clear();

            foreach (DataRow row in dtBenhNhan.Rows)
            {
                dgvBenhNhan.Rows.Add(i, row["IDPhieu"], row["HoTen"]);
                i = i + 1;
            }
        }

        private void LoadDSDaXuat()
        {
            DataTable dtBenhNhan = new DataTable();
            dtBenhNhan = dp.ReadNoParemeter("sp_ReadDSHoaDon");
            int i = 1;
            dgvHoaDon.Rows.Clear();
            foreach (DataRow row in dtBenhNhan.Rows)
            {
                dgvHoaDon.Rows.Add(i, row["ID"], row["HoTen"], row["NgayKham"], row["TienKham"], row["TienThuoc"]);
                i = i + 1;
            }
        }
        int _IDPhieu = 0;
        private void dataGridView2_DoubleClick(object sender, System.EventArgs e)
        {
            try
            {
                if (dgvBenhNhan.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvBenhNhan.Rows[dgvBenhNhan.CurrentRow.Index].Cells[1].Value.ToString());
                    txtNgay.Text = cboChonNgay.Text;
                    txtHoTen.Text = dgvBenhNhan.Rows[dgvBenhNhan.CurrentRow.Index].Cells[2].Value.ToString();
                    TinhTienThuoc(n);
                    _IDPhieu = n;
                }
            }
            catch
            {

            }
        }

        private void TinhTienThuoc(int idPhieu)
        {
            string[] str = new string[] { "@idphieu" };
            object[] val = new object[] { idPhieu };
            DataTable dtBenhNhan = new DataTable();
            dtBenhNhan = dp.ReadDataAddPram("sp_ReadTinhTienHoaDon", str, val, 100);
            DataRow dr = dtBenhNhan.Rows[0];
            txtTienThuoc.Text = dr["TienThuoc"].ToString();
            if (txtTienThuoc.Text.ToString() == "")
                txtTienThuoc.Text = "0";
        }

        private void dgvHoaDon_CurrentCellChanged(object sender, System.EventArgs e)
        {
            try
            {
                if (dgvHoaDon.CurrentCellAddress.Y >= 0)
                {
                    // int n = int.Parse(dgvCachDung.Rows[dgvCachDung.CurrentRow.Index].Cells[0].Value.ToString());
                    txtHoTen.Text = dgvHoaDon.Rows[dgvHoaDon.CurrentRow.Index].Cells[2].Value.ToString();
                    txtNgay.Text = dgvHoaDon.Rows[dgvHoaDon.CurrentRow.Index].Cells[3].Value.ToString();
                    txtTienKham.Text = dgvHoaDon.Rows[dgvHoaDon.CurrentRow.Index].Cells[4].Value.ToString();
                    txtTienThuoc.Text = dgvHoaDon.Rows[dgvHoaDon.CurrentRow.Index].Cells[5].Value.ToString();
                }
            }
            catch
            {

            }
        }

        private void btnXuat_Click(object sender, System.EventArgs e)
        {
            try
            {
                if (_IDPhieu == 0)
                    return;

                if (txtHoTen.Text.ToString() == "")
                    return;

                SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                p.Direction = ParameterDirection.Output;
                int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_InserHoaDon",
                new SqlParameter { ParameterName = "@IDPhieu", Value = _IDPhieu },
                new SqlParameter { ParameterName = "@HoTen", Value = txtHoTen.Text },
                new SqlParameter { ParameterName = "@NgayKham", Value = DateTime.Parse(txtNgay.Text)},
                new SqlParameter { ParameterName = "@TienKham", Value = txtTienKham.Text },
                new SqlParameter { ParameterName = "@TienThuoc", Value = txtTienThuoc.Text }, p);

                if (result <= 0)
                {
                    MessageBox.Show("Loi!", "ThongBao");
                    return;
                }
                else
                {                 
                    LoadDSDaXuat();
                    XoaTrang();
                    LoadDSCanXuat();
                    MessageBox.Show("Thành công", "ThongBao");
                    return;
                }

            }
            catch
            {

            }
            
        }

        private void btnXoa_Click(object sender, System.EventArgs e)
        {
            try
            {
                if (dgvHoaDon.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvHoaDon.Rows[dgvHoaDon.CurrentRow.Index].Cells[1].Value.ToString());
                    if (MessageBox.Show("Bạn muốn Xóa thông tin này", "ThongBao", MessageBoxButtons.YesNo) == DialogResult.Yes)
                    {
                        SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                        p.Direction = ParameterDirection.Output;
                        int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_DeleteHoaDon",
                        new SqlParameter { ParameterName = "@ID", Value = n }, p);

                        if (result <= 0)
                        {
                            MessageBox.Show("Loi!", "ThongBao");
                            return;
                        }
                        else
                        {
                            LoadDSDaXuat();
                            XoaTrang();
                            LoadDSCanXuat();
                            MessageBox.Show("Thành công", "ThongBao");
                            return;
                        }
                    }
                }
            }
            catch
            {

            }
        }




        //public class BenhNhanDTO
        //{
        //    int _idBenhNhan;
        //    public int idBenhNhan
        //    {
        //        get { return _idBenhNhan; }
        //        set { _idBenhNhan = value; }
        //    }

        //    string _tenBenhNhan;
        //    public string tenBenhNhan
        //    {
        //        get { return _tenBenhNhan; }
        //        set { _tenBenhNhan = value; }
        //    }
        //}
        //private void LoadTreeViwew()
        //{
        //    DataTable dt = new DataTable();
        //    dt = dp.FillBang("select distinct NgayKham from PhieuKhamBenh order by NgayKham");
        //    for (int i = 0; i < dt.Rows.Count; i++)
        //    {
        //        string ngaykham = dt.Rows[i]["NgayKham"].ToString();
        //        TreeNode nodeNgay = new TreeNode(String.Format("{0:dd/MM/yyyy}", DateTime.Parse(ngaykham)));
        //        tvDanhSach.Nodes.Add(nodeNgay);


        //        string[] str = new string[] { "@NgayKham" };
        //        object[] val = new object[] { DateTime.Parse(ngaykham) };
        //        DataTable dtBenhNhan = new DataTable();
        //        dtBenhNhan = dp.ReadDataAddPram("sp_ReadLayDSBenhNhanTheoNgay", str, val, 100);

        //        for (int j = 0; j < dtBenhNhan.Rows.Count; j++)
        //        {
        //            int idphieu = int.Parse(dtBenhNhan.Rows[j]["IDPhieu"].ToString());
        //            string hoten = dtBenhNhan.Rows[j]["HoTen"].ToString();

        //            BenhNhanDTO lh = new BenhNhanDTO();
        //            lh.idBenhNhan = idphieu;
        //            lh.tenBenhNhan = hoten;

        //            TreeNode nodeBN = new TreeNode(lh.tenBenhNhan);
        //            nodeBN.Tag = lh;

        //            //tvDanhSach.TopNode.Nodes.Add(nodeBN);
        //            tvDanhSach.Nodes[i].Nodes.Add(nodeBN);

        //            //DataTable BangLop = abc.Lay_lop(MaNganh);
        //            //for (int k = 0; k < BangLop.Rows.Count; k++)
        //            //{
        //            //    string MaLop = BangLop.Rows[k]["malop"].ToString();
        //            //    string TenLop = BangLop.Rows[k]["tenlop"].ToString();
        //            //    TreeNode node111 = new TreeNode(MaLop);
        //            //    //node11.Checked = true;
        //            //    tvDanhSach.Nodes[i].Nodes[j].Nodes.Add(node111);
        //            //    // CheckBox chk = new CheckBox();
        //            //    //  chk.Name = MaLop;
        //            //    //  chk.Text = TenLop;
        //            //    //  this.Controls.Add(chk);
        //            //}
        //        }

        //        //    TreeNode node1 = new TreeNode(SubjectName,SubjectID);

        //    }
        //}

        //private void tvDanhSach_AfterSelect(object sender, TreeViewEventArgs e)
        //{
        //    TreeNode tn = e.Node;
        //    try
        //    {
        //        DateTime.ParseExact(tn.Text, "dd/MM/yyyy", null);
        //        FillGridView(tn.Text);


        //    }
        //    catch
        //    {
        //        return;
        //    }          
        //}
        //void FillGridView(string ngay)
        //{
        //    DataTable dt = new DataTable();
        //    string[] str = new string[] { "@Ngay" };
        //    object[] val = new object[] { DateTime.Parse(ngay) };
        //    dt = dp.ReadDataAddPram("sp_ReadHoaDonThanhToanTheoNgay", str, val, 300);
        //    //tvDanhSach.Rows.Clear();
        //    //foreach (DataRow row in dt.Rows)
        //    //{
        //    //    dgvPhieuKham.Rows.Add(row["ID"], row["IDBenhNhan"], row["IDDoanBenh"], row["HoTen"], row["NgayKham"], row["TrieuChung"], row["LoaiBenh"]);

        //    //}
        //}
        //private void tvDanhSach_DoubleClick(object sender, System.EventArgs e)
        //{
        //    txtHoTen.Text = tvDanhSach.SelectedNode.Text;

        //}
    }
}
