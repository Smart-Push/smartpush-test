import { Transaction } from "../models/Transaction";

const TransactionItem: React.FC<{ transaction: Transaction; onClick: () => void }> = (props) => {
  
  return (
    <tr className="text-gray-700 dark:text-gray-100 cursor-pointer border-l-4 dark:border-gray-700" onClick={props.onClick}>
      <td className="px-4 py-3">
        {props.transaction.id}
      </td>
      <td className="px-4 py-3">
        {props.transaction.label}
      </td>
    </tr>
  );
}

export default TransactionItem;
