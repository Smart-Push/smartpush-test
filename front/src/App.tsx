import Header from "./components/Header";
import Transactions from "./components/Transactions";

function App() {
  
  return (
    <div className="flex h-screen bg-gray-50 dark:bg-gray-900">
      <div className="flex flex-col flex-1 w-full">
        <Header />
        <main className="w-full h-full overflow-y-auto">
					<div className="container grid py-6 px-6 mx-auto">
            <Transactions />
          </div>
        </main>
      </div>
    </div>
  );
}

export default App;
