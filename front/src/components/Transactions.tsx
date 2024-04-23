import { useState, useCallback, useEffect } from "react";
import { fetchData } from "../utils/ApiUtils";
import { Transaction } from "../models/Transaction";
import TransactionItem from "./TransactionItem";
import TransactionsSearchForm from "./TransactionsSearchForm";
import TextWrapper from "./UI/TextWrapper";
import Alert from "./UI/Alert";

const Transactions: React.FC<{onTransactionClick: (transactionId: number) => void }>= (props) => {

  const [loadedTransactions, setLoadedTransactions] = useState<Transaction[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [error, setError] = useState<null | string>(null);

  const fetchTransactions = useCallback(async (searchQuery?: string) => {
    setIsLoading(true);
    try {
      let url = `${process.env.REACT_APP_API_URL}/transactions`;
      if (searchQuery) {
        url += `?q=${searchQuery}`
      }
      const data = await fetchData(url);
      setLoadedTransactions(data);
    } catch (error) {
      setError(error instanceof Error ? error.message : "Failed to fetch transactions.");
    } finally {
      setIsLoading(false);
    }
  }, []);

  useEffect(() => {
    fetchTransactions();
  }, [fetchTransactions]);

  const transactionsSearchHandler = (searchQuery: string) => {
    if (searchQuery.trim().length === 0) {
      fetchTransactions();
    } else {
      fetchTransactions(searchQuery);
    }
  }
  
  return (
    <>
      
      {!isLoading && error &&
        <div className="mb-4">
          <Alert text={error} />
        </div>
      }

      <TransactionsSearchForm onSearch={transactionsSearchHandler}/>

      <div className="w-full rounded-lg shadow-md">

        <table className="w-full whitespace-no-wrap">

          <thead>
            <tr className="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b border-l-4 dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th className="px-4 py-3 w-1">ID</th>
              <th className="px-4 py-3">Label</th>
            </tr>
          </thead>

          {!isLoading && !error && loadedTransactions.length > 0 && 
              <tbody className="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                {loadedTransactions.map((transaction: Transaction) => (
                  <TransactionItem 
                    key={transaction.id} 
                    transaction={transaction} 
                    onClick={props.onTransactionClick.bind(null, transaction.id)}
                  />
                ))}
              </tbody>
          }

        </table>

        {!isLoading && loadedTransactions.length === 0 &&
          <TextWrapper text="No transactions found" />
        }

        {isLoading && <TextWrapper text="Loading..." />}

      </div>
    </>
  );
}

export default Transactions;
