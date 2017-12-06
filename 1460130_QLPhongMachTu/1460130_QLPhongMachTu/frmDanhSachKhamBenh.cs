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
    public partial class frmDanhSachKhamBenh : Form
    {
        static DataConnect dp = new DataConnect();

        public frmDanhSachKhamBenh()
        {
            InitializeComponent();
        }

        private void frmDanhSachKhamBenh_Load(object sender, EventArgs e)
        {
            Loading();
        }

        private void Loading()
        {

            DataTable dt = new DataTable();
            dt = dp.FillBang("select * from DSKhamBenh");
            dataGridView1.DataSource = dt;
        }

        private void Add()
        {
            try
            {
                SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                p.Direction = ParameterDirection.Output;
                int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_InserDSKhamBenh",
                new SqlParameter { ParameterName = "@Ngay", Value = dtpNgay.Value },
                new SqlParameter { ParameterName = "@HoTen", Value = txtHoTen.Text },
                new SqlParameter { ParameterName = "@GioiTinh", Value = chkNam.Checked },
                new SqlParameter { ParameterName = "@NamSinh", Value = txtNamSinh.Text},
                new SqlParameter { ParameterName = "@DiaChi", Value = txtDiaChi.Text }, p);

                if (result <= 0)
                {
                    MessageBox.Show("Loi!", "ThongBao");
                }
                else
                {
                    XoaTrang();
                    Loading();
                    MessageBox.Show("Thành công", "ThongBao");
                }

            }
            catch
            {

            }

        }

        private void Delete()
        {
            try
            {
                if (dataGridView1.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dataGridView1.Rows[dataGridView1.CurrentRow.Index].Cells[0].Value.ToString());
                    if (MessageBox.Show("Bạn muốn xóa thông tin này", "ThongBao", MessageBoxButtons.YesNo) == DialogResult.Yes)
                    {
                        SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                        p.Direction = ParameterDirection.Output;
                        int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_DeleteDSKhamBenh",
                        new SqlParameter { ParameterName = "@ID", Value = n }, p);

                        if (result <= 0)
                        {
                            MessageBox.Show("Loi!", "ThongBao");
                        }
                        else
                        {
                            Loading();
                            MessageBox.Show("Thành công", "ThongBao");
                        }
                    }
                }
            }
            catch
            {

            }
        }

        private void Update()
        {
            try
            {
                if (dataGridView1.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dataGridView1.Rows[dataGridView1.CurrentRow.Index].Cells[0].Value.ToString());
                    SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                    p.Direction = ParameterDirection.Output;
                    int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_UpdateDSKhamBenh",
                    new SqlParameter { ParameterName = "@ID", Value = n },
                    new SqlParameter { ParameterName = "@Ngay", Value = dtpNgay.Value },
                    new SqlParameter { ParameterName = "@HoTen", Value = txtHoTen.Text },
                    new SqlParameter { ParameterName = "@GioiTinh", Value = chkNam.Checked },
                    new SqlParameter { ParameterName = "@NamSinh", Value = txtNamSinh.Text },
                    new SqlParameter { ParameterName = "@DiaChi", Value = txtDiaChi.Text }, p);

                    if (result <= 0)
                    {
                        MessageBox.Show("Loi!", "ThongBao");
                    }
                    else
                    {
                        XoaTrang();
                        Loading();
                        MessageBox.Show("Thành công", "ThongBao");
                    }
                }
            }
            catch
            {

            }
        }

        private void dataGridView1_CurrentCellChanged(object sender, EventArgs e)
        {
            try
            {
                if (dataGridView1.CurrentCellAddress.Y >= 0)
                {
                    // int n = int.Parse(dgvCachDung.Rows[dgvCachDung.CurrentRow.Index].Cells[0].Value.ToString());
                    txtHoTen.Text = dataGridView1.Rows[dataGridView1.CurrentRow.Index].Cells[2].Value.ToString();
                    chkNam.Checked = bool.Parse(dataGridView1.Rows[dataGridView1.CurrentRow.Index].Cells[3].Value.ToString());
                    if (chkNam.Checked == true)
                        chkNu.Checked = false;
                    else
                        chkNu.Checked = true;
                    txtNamSinh.Text = dataGridView1.Rows[dataGridView1.CurrentRow.Index].Cells[4].Value.ToString();
                    txtDiaChi.Text = dataGridView1.Rows[dataGridView1.CurrentRow.Index].Cells[5].Value.ToString();
                    dtpNgay.Value = DateTime.Parse(dataGridView1.Rows[dataGridView1.CurrentRow.Index].Cells[1].Value.ToString());
                }
            }
            catch
            {

            }
        }

        private void btnCapNhat_Click(object sender, EventArgs e)
        {
            Update();
            XoaTrang();
        }

        private void btnThem_Click(object sender, EventArgs e)
        {
            Add();
            XoaTrang();
        }

        private void btnXoa_Click(object sender, EventArgs e)
        {
            Delete();
        }

        private void XoaTrang()
        {
            txtHoTen.Text = "";
            txtNamSinh.Text = "";
            txtDiaChi.Text = "";
            chkNam.Checked = true;
            chkNu.Checked = false;
        }

        private void btnXoaTrang_Click(object sender, EventArgs e)
        {
            XoaTrang();
        }
    }
}
