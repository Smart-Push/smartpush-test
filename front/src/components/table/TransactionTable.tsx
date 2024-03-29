import {
  GridCallbackDetails,
  GridColDef,
  GridRowSelectionModel,
} from "@mui/x-data-grid";
import { Alert, AlertTitle, CircularProgress } from "@mui/material";
import { useCallback, useEffect, useState } from "react";
import DataTable from "./DataTable";
import { DetailedTransaction, TrunkedTransaction } from "../../utils/types";

const columns: GridColDef[] = [
  { field: "id", headerName: "ID", width: 70 },
  { field: "label", headerName: "Label", width: 130 },
];

export default function TransactionTable() {
  const [rows, setRows] = useState<TrunkedTransaction[]>([]);
  const [isLoading, isSetIsLoading] = useState<boolean>(false);
  const [hasFailed, setHasFailed] = useState<boolean>(false);
  const [detailedTransaction, setDetailedTransaction] =
    useState<DetailedTransaction>();

  const [selectedRowId, setSelectedRowId] = useState<number>(0);

  const handleRowSelectionModelChange = (
    rowSelectionModel: GridRowSelectionModel,
    details: GridCallbackDetails<any>
  ) => {
    const selectedRowId = rowSelectionModel.shift();

    if (selectedRowId) {
      setSelectedRowId(Number(selectedRowId));
    }
  };

  // declare the async data fetching function
  const fetchTrunkedTransactions = useCallback(async () => {
    const query = await fetch("http://localhost/api/transactions");
    const data = await query.json();

    setRows(data);
    isSetIsLoading(false);
  }, []);

  const fetchDetailedTransaction = async () => {
    const query = await fetch(
      `http://localhost/api/transactions/${selectedRowId}`
    );
    const data = await query.json();

    setDetailedTransaction(data);
    isSetIsLoading(false);
  };

  // the useEffect is only there to call `fetchData` at the right time
  useEffect(() => {
    isSetIsLoading(true);

    fetchTrunkedTransactions()
      // make sure to catch any error
      .catch((...args) => {
        console.error(...args);
        setHasFailed(true);
      });
  }, [fetchTrunkedTransactions]);

  useEffect(() => {
    if (selectedRowId) {
      isSetIsLoading(true);
      fetchDetailedTransaction();
    }
  }, [selectedRowId]);

  return (
    <>
      {hasFailed && <Alert severity="error">Something went wrong.</Alert>}
      {detailedTransaction && (
        <Alert severity="info">
          <AlertTitle>Detailed Transaction</AlertTitle>
          <pre>{JSON.stringify(detailedTransaction, null, 2)}</pre>
        </Alert>
      )}
      {isLoading && !hasFailed && <CircularProgress />}
      {rows.length && (
        <DataTable
          columns={columns}
          rows={rows}
          onRowSelectionModelChange={handleRowSelectionModelChange}
        />
      )}
    </>
  );
}
