import { useState, useCallback, useEffect } from "react";
import { Transaction } from "../models/Transaction";
import TextWrapper from "./UI/TextWrapper";
import Alert from "./UI/Alert";

const TransactionDetails: React.FC<{ transactionId?: number }> = (props) => {

  const [loadedTransaction, setLoadedTransaction] = useState<null | Transaction>(null);
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [error, setError] = useState<null | string>(null);

  const fetchTransaction = useCallback(async (transactionId: number) => {
    setIsLoading(true);
    try {
      const response = await fetch(`${process.env.REACT_APP_API_URL}/transactions/${transactionId}`);
      const data = await response.json();
      if (!response.ok) {
        throw Error(data.message);
      } else {
        setLoadedTransaction(data);
      }
    } catch (error) {
      setError(error instanceof Error ? error.message : "Failed to fetch transaction details.");
    }
    setIsLoading(false);
  }, []);

  useEffect(() => {
    if (props.transactionId) {
      fetchTransaction(props.transactionId);
    }
  }, [props.transactionId, fetchTransaction]);
  
  return (
    <div className="rounded-lg shadow-md my-4 bg-white dark:bg-gray-800">
      
      {isLoading && <TextWrapper text="Loading..." />}
      
      {!isLoading && (loadedTransaction || error) &&
        
        <div className="text-xs font-semibold tracking-wide text-left text-gray-500 border-b border-l-4 dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
          
          <h2 className="flex items-center p-4 uppercase">
            Transaction details
          </h2>

          {error && <Alert text={error} />}

          {!error && loadedTransaction && 
            <div className="text-gray-700 dark:text-gray-200">
              <table className="w-full whitespace-no-wrap">
                <tbody>
                  <tr className="text-gray-700 dark:text-gray-100 border-b dark:border-gray-700">
                    <td className="w-2 px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                      ID
                    </td>
                    <td className="px-4 py-3 bg-white dark:bg-gray-800">
                      {loadedTransaction.id}
                    </td>
                  </tr>
                  <tr className="text-gray-700 dark:text-gray-100 border-b dark:border-gray-700">
                    <td className="w-2 px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                      Label
                    </td>
                    <td className="px-4 py-3 bg-white dark:bg-gray-800">
                      {loadedTransaction.label}
                    </td>
                  </tr>
                  <tr className="text-gray-700 dark:text-gray-100">
                    <td className="w-2 px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                      Amount
                    </td>
                    <td className="px-4 py-3 bg-white dark:bg-gray-800">
                      {loadedTransaction.amount}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          }
        </div>
      }
    </div>
  );
}

export default TransactionDetails;
