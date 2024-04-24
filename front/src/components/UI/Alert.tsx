const Error: React.FC<{ text: string }> = (props) => {

  return (
    <div className="flex items-center p-4 text-yellow-800 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800" role="alert">
      <svg className="flex-shrink-0 inline w-5 h-5 mr-3" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
        <path fillRule="evenodd" clipRule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" />
      </svg>
      <div className="ml-3 text-sm font-medium">
        { props.text }
      </div>
    </div>
  )
}

export default Error;