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
    public partial class frmThuoc : Form
    {
        static DataConnect dp = new DataConnect();
        public frmThuoc()
        {
            InitializeComponent();
        }

        private void Loading()
        {

            DataTable dt = new DataTable();
            dt = dp.FillBang("select * from Thuoc order by TenThuoc");
            dgvThuoc.DataSource = dt;
        }

        private void Add()
        {
            try
            {
                SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                p.Direction = ParameterDirection.Output;
                int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_InserThuoc",
                new SqlParameter { ParameterName = "@Ten", Value = txtTen.Text }, p);

                if (result <= 0)
                {
                    MessageBox.Show("Loi!", "ThongBao");
                }
                else
                {
                    txtTen.Text = "";
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
                if (dgvThuoc.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvThuoc.Rows[dgvThuoc.CurrentRow.Index].Cells[0].Value.ToString());
                    if (MessageBox.Show("Bạn muốn sửa thông tin này", "ThongBao", MessageBoxButtons.YesNo) == DialogResult.Yes)
                    {
                        SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                        p.Direction = ParameterDirection.Output;
                        int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_DeleteThuoc",
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
                if (dgvThuoc.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvThuoc.Rows[dgvThuoc.CurrentRow.Index].Cells[0].Value.ToString());
                    SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                    p.Direction = ParameterDirection.Output;
                    int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_UpdateThuoc",
                    new SqlParameter { ParameterName = "@Ten", Value = txtTen.Text },
                    new SqlParameter { ParameterName = "@ID", Value = n }, p);

                    if (result <= 0)
                    {
                        MessageBox.Show("Loi!", "ThongBao");
                    }
                    else
                    {
                        txtTen.Text = "";
                        Loading();
                        MessageBox.Show("Thành công", "ThongBao");
                    }
                }
            }
            catch
            {

            }
        }

        private void btnXoa_Click(object sender, EventArgs e)
        {
            Delete();
        }

        private void btnThem_Click(object sender, EventArgs e)
        {
            Add();
        }

        private void btnCapNhat_Click(object sender, EventArgs e)
        {
            Update();
        }

        private void frmThuoc_Load(object sender, EventArgs e)
        {
            Loading();
        }

        private void dgvThuoc_CurrentCellChanged(object sender, EventArgs e)
        {
            try
            {
                if (dgvThuoc.CurrentCellAddress.Y >= 0)
                {
                    // int n = int.Parse(dgvCachDung.Rows[dgvCachDung.CurrentRow.Index].Cells[0].Value.ToString());
                    txtTen.Text = dgvThuoc.Rows[dgvThuoc.CurrentRow.Index].Cells[1].Value.ToString();
                    
                }
            }
            catch
            {

            }
        }
    }
}
