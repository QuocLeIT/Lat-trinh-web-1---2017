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
    public partial class frmBaoCao : Form
    {
        static DataConnect dp = new DataConnect();
        public frmBaoCao()
        {
            InitializeComponent();
        }

        private void frmBaoCao_Load(object sender, EventArgs e)
        {
            LoadCbo();
        }

        private void LoadCbo()
        {
            for (int i = 1; i <= 12;i++ )
            {
                cbo1.Items.Add(i);
                cbo2.Items.Add(i);
            }
          
        }

        private void btnXem1_Click(object sender, EventArgs e)
        {
            if (cbo1.Text == "" || txtNam.Text.ToString() == "")
            {
                MessageBox.Show("Nhập thông tin tháng, năm");
                return;

            }

            string[] str = new string[] { "@Thang" , "@Nam"};
            object[] val = new object[] { Int32.Parse(cbo1.Text), Int32.Parse(txtNam.Text) };
            DataTable dtBenhNhan = new DataTable();
            dtBenhNhan = dp.ReadDataAddPram("sp_ReadBCDoanhThuTheoNgay", str, val, 100);
            int i = 1;
            dgv1.Rows.Clear();

            if (dtBenhNhan.Rows.Count < 1)
            {
                MessageBox.Show("Không có dữ liệu!");
                return;

            }

            foreach (DataRow row in dtBenhNhan.Rows)
            {
                dgv1.Rows.Add(i, row["NgayKham"], row["SoBenhNhan"], row["DoanhThu"]);
                i = i + 1;
            }
        }

        private void btnXem2_Click(object sender, EventArgs e)
        {
            if (cbo2.Text == "" || txtNam.Text.ToString() == "")
            {
                MessageBox.Show("Nhập thông tin tháng, năm");
                return;

            }

            string[] str = new string[] { "@Thang", "@Nam" };
            object[] val = new object[] { Int32.Parse(cbo2.Text), Int32.Parse(txtNam.Text) };
            DataTable dtBenhNhan = new DataTable();
            dtBenhNhan = dp.ReadDataAddPram("sp_ReadBCSuDungThuoc", str, val, 100);
            int i = 1;
            dgv2.Rows.Clear();

            if (dtBenhNhan.Rows.Count < 1)
            {
                MessageBox.Show("Không có dữ liệu!");
                return;

            }

            foreach (DataRow row in dtBenhNhan.Rows)
            {
                dgv2.Rows.Add(i, row["TenThuoc"], row["TenDonViTinh"], row["SoLuong"]);
                i = i + 1;
            }
        }
    }
}
