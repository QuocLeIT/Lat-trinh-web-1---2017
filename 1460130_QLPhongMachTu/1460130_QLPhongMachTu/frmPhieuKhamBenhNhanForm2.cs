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
    public partial class frmPhieuKhamBenhNhanForm2 : Form
    {
        static DataConnect dp = new DataConnect();
        static XuLy xl = new XuLy();
        public frmPhieuKhamBenhNhanForm2()
        {
            InitializeComponent();
        }

        private void frmPhieuKhamBenhNhanForm2_Load(object sender, EventArgs e)
        {
            LoadCboHoTen();
            LoadCboLoaiBenh();
            LoadCboThuoc();
            LoadCboDonViTinh();
            LoadCboCachDung();

            LoadPhieuKham();
        }

        private void LoadPhieuKham()
        {

            DataTable dt = new DataTable();
            string[] str = new string[] { "@Ngay" };
            object[] val = new object[] { dtpNgay.Value };
            dt = dp.ReadDataAddPram("sp_ReadPhieuKhamBenh", str, val, 300);
            dgvPhieuKham.Rows.Clear();
            foreach (DataRow row in dt.Rows)
            {
                dgvPhieuKham.Rows.Add(row["ID"], row["IDBenhNhan"], row["IDDoanBenh"], row["HoTen"], row["NgayKham"], row["TrieuChung"], row["LoaiBenh"]);

            }
           
        }

        private void LoadChietTietPhieu(int idphieu)
        {
            DataTable dt = new DataTable();
            string[] str = new string[] { "@idphieu" };
            object[] val = new object[] { idphieu };
            dt = dp.ReadDataAddPram("sp_ReadChiTietPhieuKhamBenh", str, val, 300);
            dgvChiTiet.Rows.Clear();
            foreach (DataRow row in dt.Rows)
            {
                dgvChiTiet.Rows.Add(row["ID"], row["IDThuoc"], row["IDDonViThuoc"], row["IDCachDung"], row["TenThuoc"], row["TenDonViTinh"], row["SoLuong"], row["TenCachDung"]);

            }
           
        }

        private void LoadCboHoTen()
        {
            DataTable dt = new DataTable();
            dt = dp.FillBang("select ID, HoTen from DSKhamBenh");
            cboHoTen.DataSource = dt;
            cboHoTen.DisplayMember = "HoTen";
            cboHoTen.ValueMember = "ID";
        }

        private void LoadCboLoaiBenh()
        {
            DataTable dt = new DataTable();
            dt = dp.FillBang("select ID, LoaiBenh from Loaibenh");
            cboLoaiBenh.DataSource = dt;
            cboLoaiBenh.DisplayMember = "LoaiBenh";
            cboLoaiBenh.ValueMember = "ID";
        }

        private void LoadCboThuoc()
        {
            DataTable dt = new DataTable();
            dt = dp.FillBang("select ID, TenThuoc from Thuoc");
            cboThuoc.DataSource = dt;
            cboThuoc.DisplayMember = "TenThuoc";
            cboThuoc.ValueMember = "ID";
        }

        private void LoadCboDonViTinh()
        {
            DataTable dt = new DataTable();
            dt = dp.FillBang("select ID, TenDonViTinh from DonViTinh");
            cboDonViTinh.DataSource = dt;
            cboDonViTinh.DisplayMember = "TenDonViTinh";
            cboDonViTinh.ValueMember = "ID";
        }

        private void LoadCboCachDung()
        {
            DataTable dt = new DataTable();
            dt = dp.FillBang("select ID, TenCachDung from CachDung");
            cboCachDung.DataSource = dt;
            cboCachDung.DisplayMember = "TenCachDung";
            cboCachDung.ValueMember = "ID";
        }



        private void butThem_Click(object sender, System.EventArgs e)
        {
            dgvChiTiet.Rows.Add("" ,cboThuoc.SelectedValue, cboDonViTinh.SelectedValue, cboCachDung.SelectedValue, cboThuoc.Text, cboDonViTinh.Text, txtSoLuong.Text, cboCachDung.Text);
            txtSoLuong.Text = "";
        }

        private void butXoa_Click(object sender, System.EventArgs e)
        {
            if (dgvChiTiet.CurrentCellAddress.Y >= 0)
            {
                int n = int.Parse(dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[0].Value.ToString());
                if (MessageBox.Show("Bạn muốn xóa thuốc này", "ThongBao", MessageBoxButtons.YesNo) == DialogResult.Yes)
                {
                    SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                    p.Direction = ParameterDirection.Output;
                    int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_DeleteChiTietPhieuKhamBenh",
                    new SqlParameter { ParameterName = "@ID", Value = n }, p);

                    if (result <= 0)
                    {
                        MessageBox.Show("Loi!", "ThongBao");
                    }
                    else
                    {
                        dgvChiTiet.Rows.Remove(dgvChiTiet.CurrentRow);
                        MessageBox.Show("Thành công", "ThongBao");
                    }
                }
            }
        }

        private void butCapNhat_Click(object sender, System.EventArgs e)
        {
            try
            {
                if (dgvChiTiet.CurrentCellAddress.Y >= 0)
                {
                   // int n = int.Parse(dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[0].Value.ToString());
                    dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[1].Value = cboThuoc.SelectedValue;
                    dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[2].Value = cboDonViTinh.SelectedValue;
                    dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[3].Value = cboCachDung.SelectedValue;

                    dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[4].Value = cboThuoc.Text;
                    dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[5].Value = cboDonViTinh.Text;
                    dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[6].Value = txtSoLuong.Text;
                    dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[7].Value = cboCachDung.Text;
    
                }
            }
            catch
            {

            }
        }

        private void dgvChiTiet_CurrentCellChanged(object sender, System.EventArgs e)
        {
            try
            {
                if (dgvChiTiet.CurrentCellAddress.Y >= 0)
                {
                    //int n = int.Parse(dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[0].Value.ToString());
                    cboThuoc.SelectedValue = dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[1].Value;
                    cboDonViTinh.SelectedValue = dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[2].Value;
                    txtSoLuong.Text = dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[6].Value.ToString();
                    cboCachDung.SelectedValue = dgvChiTiet.Rows[dgvChiTiet.CurrentRow.Index].Cells[3].Value;
                }
                else
                    txtSoLuong.Text = "";
            }
            catch
            {

            }
        }

        private void btnCapNhat_Click(object sender, System.EventArgs e)
        {
            try
            {
                if (dgvPhieuKham.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvPhieuKham.Rows[dgvPhieuKham.CurrentRow.Index].Cells[0].Value.ToString());
                    SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                    p.Direction = ParameterDirection.Output;
                    int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_UpdatePhieuKhamBenh",
                    new SqlParameter { ParameterName = "@ID", Value = n },
                    new SqlParameter { ParameterName = "@IDHoTen", Value = cboHoTen.SelectedValue },
                    new SqlParameter { ParameterName = "@Ngay", Value = dtpNgay.Value },
                    new SqlParameter { ParameterName = "@TrieuChung", Value = txtTieuChung.Text },
                    new SqlParameter { ParameterName = "@IDLoaiBenh", Value = cboLoaiBenh.SelectedValue }, p);

                    if (result <= 0)
                    {
                        MessageBox.Show("Loi!", "ThongBao");
                    }
                    else
                    {
                        
                        if (UpdateChiTiet(n) == 1)
                        {
                            XoaTrang();
                            LoadPhieuKham();
                            LoadChietTietPhieu(n);
                            MessageBox.Show("Thành công", "ThongBao");
                        }
                        else
                            MessageBox.Show("Loi update chi tiet!", "ThongBao");
                    }
                }
            }
            catch
            {

            }
        }

        private int UpdateChiTiet(int idphieu)
        {
            foreach (DataGridViewRow row in dgvChiTiet.Rows)
            {
                int result=-2;

                if (row.Cells[0].Value.ToString() == "")//them thuoc moi vao thi Insert
                {
                   SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                   p.Direction = ParameterDirection.Output;
                   result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_InserChiTietPhieuKhamBenhNhan",
                   new SqlParameter { ParameterName = "@IDPhieu", Value = idphieu },
                   new SqlParameter { ParameterName = "@IDThuoc", Value = row.Cells[1].Value },
                   new SqlParameter { ParameterName = "@IDDonViTinh", Value = row.Cells[2].Value },
                   new SqlParameter { ParameterName = "@SoLuong", Value = row.Cells[6].Value },
                   new SqlParameter { ParameterName = "@IDCachDung", Value = row.Cells[3].Value }, p);
                }
                else //cap nhat thong tin thuoc thi update
                {
                    SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                    p.Direction = ParameterDirection.Output;
                    result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_UpdateChiTietPhieuKhamBenhNhan",
                    new SqlParameter { ParameterName = "@ID", Value = row.Cells[0].Value },
                    new SqlParameter { ParameterName = "@IDThuoc", Value = row.Cells[1].Value },
                    new SqlParameter { ParameterName = "@IDDonViTinh", Value = row.Cells[2].Value },
                    new SqlParameter { ParameterName = "@SoLuong", Value = row.Cells[6].Value },
                    new SqlParameter { ParameterName = "@IDCachDung", Value = row.Cells[3].Value }, p);
                } 

                if (result <= 0)
                    return 0;
                
            }

            return 1;
        }

        private void btnThem_Click(object sender, System.EventArgs e)
        {
            try
            {
                SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                p.Direction = ParameterDirection.Output;
                int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_InserPhieuKhamBenhNhan",
                new SqlParameter { ParameterName = "@IDHoTen", Value = cboHoTen.SelectedValue },
                new SqlParameter { ParameterName = "@Ngay", Value = dtpNgay.Value },
                new SqlParameter { ParameterName = "@TrieuChung", Value = txtTieuChung.Text },
                new SqlParameter { ParameterName = "@IDLoaiBenh", Value = cboLoaiBenh.SelectedValue }, p);

                if (result <= 0)
                {
                    MessageBox.Show("Loi!", "ThongBao");
                }
                else
                {
                    result = int.Parse(dp.FillBang("select max(ID) from PhieuKhamBenh").Rows[0].ItemArray[0].ToString());
                    if (AddChiTiet(result) == 1)
                    {
                        XoaTrang();
                        LoadPhieuKham();
                        MessageBox.Show("Thành công", "ThongBao");
                    }
                    else
                        MessageBox.Show("Loi them chi tiet!", "ThongBao");
                   
                }

            }
            catch
            {

            }
        }


        private int AddChiTiet(int idphieu)
        {
            foreach (DataGridViewRow row in dgvChiTiet.Rows)
            {
                SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                p.Direction = ParameterDirection.Output;
                int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_InserChiTietPhieuKhamBenhNhan",
               new SqlParameter { ParameterName = "@IDPhieu", Value = idphieu },
               new SqlParameter { ParameterName = "@IDThuoc", Value = row.Cells[1].Value },
               new SqlParameter { ParameterName = "@IDDonViTinh", Value = row.Cells[2].Value },
               new SqlParameter { ParameterName = "@SoLuong", Value = row.Cells[6].Value },
               new SqlParameter { ParameterName = "@IDCachDung", Value = row.Cells[3].Value }, p);
                
               if (result <= 0)
                   return 0;
   
            }

            return 1;
        }
        private void btnXoa_Click(object sender, System.EventArgs e)
        {
            try
            {
                if (dgvPhieuKham.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvPhieuKham.Rows[dgvPhieuKham.CurrentRow.Index].Cells[0].Value.ToString());
                    if (MessageBox.Show("Bạn muốn Xóa thông tin này.", "ThongBao", MessageBoxButtons.YesNo) == DialogResult.Yes)
                    {
                        SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                        p.Direction = ParameterDirection.Output;
                        int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_DeletePhieuKhamBenh",
                        new SqlParameter { ParameterName = "@ID", Value = n }, p);

                        if (result <= 0)
                        {
                            MessageBox.Show("Loi!", "ThongBao");
                        }
                        else
                        {
                            LoadPhieuKham();
                            MessageBox.Show("Thành công", "ThongBao");
                        }
                    }
                }
            }
            catch
            {

            }
        }

        private void XoaTrang()
        {
            dgvChiTiet.Rows.Clear();
            txtTieuChung.Text = "";
            txtSoLuong.Text = "";
        }

        private void btnXoaTrang_Click(object sender, System.EventArgs e)
        {
            XoaTrang();
        }

        private void dgvPhieuKham_CurrentCellChanged(object sender, EventArgs e)
        {
            try
            {
                if (dgvPhieuKham.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvPhieuKham.Rows[dgvPhieuKham.CurrentRow.Index].Cells[0].Value.ToString());
                    LoadChietTietPhieu(n);
                    cboHoTen.SelectedValue = dgvPhieuKham.Rows[dgvPhieuKham.CurrentRow.Index].Cells[1].Value;
                    dtpNgay.Value = DateTime.Parse(dgvPhieuKham.Rows[dgvPhieuKham.CurrentRow.Index].Cells[4].Value.ToString());
                    txtTieuChung.Text = dgvPhieuKham.Rows[dgvPhieuKham.CurrentRow.Index].Cells[5].Value.ToString();
                    cboLoaiBenh.SelectedValue = dgvPhieuKham.Rows[dgvPhieuKham.CurrentRow.Index].Cells[2].Value;
                }
            }
            catch
            {

            }
        } 

        private void dgvPhieuKham_CellPainting(object sender, DataGridViewCellPaintingEventArgs e)
        {
            xl.grd_CellPainting(sender, e, this.dgvPhieuKham, Font);    
        }

        private void dgvChiTiet_CellPainting(object sender, DataGridViewCellPaintingEventArgs e)
        {
            xl.grd_CellPainting(sender, e, this.dgvChiTiet, Font);    
        }
    }
}
