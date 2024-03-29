import {
  DataGrid,
  GridCallbackDetails,
  GridColDef,
  GridRowSelectionModel,
} from "@mui/x-data-grid";

interface IDataTableProps {
  columns: GridColDef[];
  rows: readonly any[] | undefined;
  onRowSelectionModelChange:
    | ((
        rowSelectionModel: GridRowSelectionModel,
        details: GridCallbackDetails<any>
      ) => void)
    | undefined;
}

export default function DataTable({
  columns,
  rows,
  onRowSelectionModelChange,
}: IDataTableProps) {
  return (
    <div style={{ height: 400, width: "100%" }}>
      <DataGrid
        rows={rows}
        columns={columns}
        initialState={{
          pagination: {
            paginationModel: { page: 0, pageSize: 5 },
          },
        }}
        pageSizeOptions={[5, 10]}
        onRowSelectionModelChange={onRowSelectionModelChange}
      />
    </div>
  );
}
