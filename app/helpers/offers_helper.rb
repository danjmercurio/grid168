module OffersHelper
	
	def day_arr
		["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]
	end

  def constituteDayparts(cells)
    # Strip trailing comma if there is one
    cells = cells[0, cells.length - 1] unless cells.last != ','
    # Split individual cells
    cells = cells.split(',')
    # For each cell...
    cells.each do |cell|
      day, time = cell.split('-')
    end
  end
end
