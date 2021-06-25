function HideTextArea(optionValue){
    if(optionValue == "folder")
        contentFile.setAttribute("hidden", "")
    else
        contentFile.removeAttribute("hidden")
}
