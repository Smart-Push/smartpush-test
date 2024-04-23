const TextWrapper: React.FC<{ text: string }> = (props) => {

  return (
    <div className="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
      <span className="flex py-3 items-center justify-center">
        { props.text }
      </span>
    </div>
  )
}

export default TextWrapper;