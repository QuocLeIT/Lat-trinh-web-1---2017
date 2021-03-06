﻿using System;
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
    public partial class frmCachDung : Form
    {
        static DataConnect dp = new DataConnect();
        public frmCachDung()
        {
            InitializeComponent();
        }

        private void frmCachDung_Load(object sender, EventArgs e)
        {
            Loading();
        }


        private void Loading()
        {

            DataTable dt = new DataTable();
            dt = dp.FillBang("select * from CachDung order by TenCachDung");
            dgvCachDung.DataSource = dt;
        }

        private void Add()
        {
            try
            {
                SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                p.Direction = ParameterDirection.Output;
                int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_InserCachDung",
                new SqlParameter { ParameterName = "@Ten", Value = txtTen.Text },
                new SqlParameter { ParameterName = "@MoTa", Value = txtMoTa.Text}, p);

                if (result <= 0)
                {
                    MessageBox.Show("Loi!", "ThongBao");
                }
                else
                {
                    txtTen.Text = "";
                    txtMoTa.Text = "";
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
                if (dgvCachDung.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvCachDung.Rows[dgvCachDung.CurrentRow.Index].Cells[0].Value.ToString());
                    if (MessageBox.Show("Bạn muốn xóa thông tin này", "ThongBao", MessageBoxButtons.YesNo) == DialogResult.Yes)
                    {
                        SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                        p.Direction = ParameterDirection.Output;
                        int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_DeleteCachDung",
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
                if (dgvCachDung.CurrentCellAddress.Y >= 0)
                {
                    int n = int.Parse(dgvCachDung.Rows[dgvCachDung.CurrentRow.Index].Cells[0].Value.ToString());
                    SqlParameter p = new SqlParameter("@resurlt", SqlDbType.VarChar, 10);
                    p.Direction = ParameterDirection.Output;
                    int result = dp.ExcuteNonQuyery(CommandType.StoredProcedure, "sp_UpdateCachDung",
                    new SqlParameter { ParameterName = "@Ten", Value = txtTen.Text },
                    new SqlParameter { ParameterName = "@MoTa", Value = txtMoTa.Text.ToString() },
                    new SqlParameter { ParameterName = "@ID", Value = n }, p);

                    if (result <= 0)
                    {
                        MessageBox.Show("Loi!", "ThongBao");
                    }
                    else
                    {
                        txtTen.Text = "";
                        txtMoTa.Text = "";
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

        private void dgvCachDung_CurrentCellChanged(object sender, EventArgs e)
        {
            try
            {
                if (dgvCachDung.CurrentCellAddress.Y >= 0)
                {
                   // int n = int.Parse(dgvCachDung.Rows[dgvCachDung.CurrentRow.Index].Cells[0].Value.ToString());
                    txtTen.Text = dgvCachDung.Rows[dgvCachDung.CurrentRow.Index].Cells[1].Value.ToString();
                    txtMoTa.Text = dgvCachDung.Rows[dgvCachDung.CurrentRow.Index].Cells[2].Value.ToString();
                }
            }
            catch
            {

            }
        }

        private void btnXoaTrang_Click(object sender, EventArgs e)
        {
            txtTen.Text = "";
            txtMoTa.Text = "";
        }
    }
}
