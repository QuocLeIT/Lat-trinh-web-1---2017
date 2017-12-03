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
    class XuLy
    {
        public void grd_CellPainting(object sender, System.Windows.Forms.DataGridViewCellPaintingEventArgs e, DataGridView grd, System.Drawing.Font font)
        {
            StringFormat StrF = new StringFormat();
            StrF.Alignment = StringAlignment.Center;

            if (e.ColumnIndex == -1 && e.RowIndex >= 0 && e.RowIndex < grd.Rows.Count)
            {
                e.PaintBackground(e.ClipBounds, true);
                e.Graphics.DrawString((e.RowIndex + 1).ToString(), font, Brushes.Black, e.CellBounds, StringFormat.GenericTypographic);
                e.Handled = true;
            }

        }
    }
}
