import { useRef } from "react";

const TransactionsSearchForm: React.FC<{onSearch: (searchQuery: string) => void }> = (props) => {
  const searchInputRef = useRef<HTMLInputElement>(null);

  const searchSubmitHandler = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    const searchQuery = searchInputRef.current!.value;
    props.onSearch(searchQuery);
  }

  return (
    <form onSubmit={searchSubmitHandler}>
        <div className="flex items-center w-full mb-4">
            <input ref={searchInputRef} type="text" placeholder="Search for transactions..."
              className="flex-grow p-2.5 border-0 rounded-l-md text-gray-700 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 focus:bg-white dark:focus:bg-gray-600 placeholder-gray-600 focus:placeholder-gray-500 dark:placeholder-gray-400 dark:focus:placeholder-gray-300 dark:focus:shadow-outline-gray focus:border-purple-300 focus:outline-none focus:shadow-outline-purple" 
            />
            <button type="submit" className="px-3 py-2.5 border border-transparent rounded-r-md text-white bg-purple-600 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
              <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
            </button>
        </div>
      </form>
  );
};

export default TransactionsSearchForm;
